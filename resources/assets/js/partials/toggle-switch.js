
module.exports = {
    props: ['name', 'value'],
    template: '#toggle-switch',
    data: function() {
        return {
            isActive: this.value == true && this.value != 'false'
        }
    },
    ready: function() {
        this.value = (this.value == true && this.value != 'false') ? 'true' : 'false';
    },
    methods: {
        switch: function() {
            this.isActive = !this.isActive;
            this.value = this.isActive ? 'true' : 'false';
        }
    }
};