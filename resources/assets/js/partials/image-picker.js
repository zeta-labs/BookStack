
module.exports = {
    props: ['currentImage', 'name', 'imageClass', 'defaultImage'],
    template: '#image-picker',
    data: function() {
        return {
            image: this.currentImage
        }
    },
    methods: {
        showImageManager: function(e) {
            var _this = this;
            ImageManager.show(function(image) {
                _this.image = image.url;
            });
        },
        reset: function() {
            this.image = '';
        },
        remove: function() {
            this.image = 'none';
        }
    }
};