var Dropzone = require('dropzone');
var events = require('../events');

module.exports = {

    el: '#image-manager',

    data:  {
        images: [],
        hasMore: false,
        page: 0,
        cClickTime: 0,
        selectedImage: false,
        dependantPages: false,
        deleteForm: {},
        token: document.querySelector('meta[name=token]').getAttribute('content'),
        dataLoaded: false
    },

    ready: function () {
        // Create dropzone
        this.setupDropZone();
    },

    methods: {
        fetchData: function () {
            var _this = this;
            this.$http.get('/images/all/' + _this.page, function (data) {
                _this.images = _this.images.concat(data.images);
                _this.hasMore = data.hasMore;
                _this.page++;
            });
        },

        setupDropZone: function () {
            var _this = this;
            var dropZone = new Dropzone(_this.$els.dropZone, {
                url: '/upload/image',
                init: function () {
                    var dz = this;
                    this.on("sending", function (file, xhr, data) {
                        data.append("_token", _this.token);
                    });
                    this.on("success", function (file, data) {
                        _this.images.unshift(data);
                        $(file.previewElement).fadeOut(400, function () {
                            dz.removeFile(file);
                        });
                    });
                }
            });
        },

        imageClick: function (image) {
            var dblClickTime = 380;
            var cTime = (new Date()).getTime();
            var timeDiff = cTime - this.cClickTime;
            if (this.cClickTime !== 0 && timeDiff < dblClickTime && this.selectedImage === image) {
                // DoubleClick
                if (this.callback) {
                    this.callback(image);
                }
                this.hide();
            } else {
                this.selectedImage = (this.selectedImage === image) ? false : image;
                this.dependantPages = false;
            }
            this.cClickTime = cTime;
        },

        selectButtonClick: function () {
            if (this.callback) {
                this.callback(this.selectedImage);
            }
            this.hide();
        },

        show: function (callback) {
            this.callback = callback;
            this.$els.overlay.style.display = 'block';
            // Get initial images if they have not yet been loaded in.
            if (!this.dataLoaded) {
                this.fetchData(this.page);
                this.dataLoaded = true;
            }
        },

        overlayClick: function (e) {
            if (e.target.className === 'overlay') {
                this.hide();
            }
        },

        hide: function () {
            this.$els.overlay.style.display = 'none';
        },

        saveImageDetails: function (e) {
            e.preventDefault();
            var _this = this;
            _this.selectedImage._token = _this.token;
            var $form = $(_this.$els.imageForm);
            $form.find('.error').remove();
            $.ajax('/images/update/' + _this.selectedImage.id, {
                method: 'PUT',
                data: _this.selectedImage
            }).done(function () {
                $form.append('<span class="success">Image Updated</span>');
            }).fail(function (jqXHR) {
                var messageString = '';
                $.each(jqXHR.responseJSON, function(key, val) {
                    messageString += val + '\n';
                    $form.append('<span class="error">'+val+'</span>');
                });
            });
        },

        deleteImage: function (e) {
            e.preventDefault();
            var _this = this;
            _this.deleteForm.force = _this.dependantPages !== false;
            _this.deleteForm._token = _this.token;
            $.ajax('/images/' + _this.selectedImage.id, {
                method: 'DELETE',
                data: _this.deleteForm
            }).done(function () {
                _this.images.splice(_this.images.indexOf(_this.selectedImage), 1);
                _this.selectedImage = false;
                $(_this.$els.imageTitle).showSuccess('Image Deleted');
            }).fail(function (jqXHR, textStatus) {
                // Pages failure
                if (jqXHR.status === 400) {
                    _this.dependantPages = jqXHR.responseJSON;
                }
            });
        }

    }

};