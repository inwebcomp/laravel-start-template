import './bootstrap'
import Translator from './services/Translator'
import Vue from 'vue'

// components
import Popup from './components/Popup'

// mixins
import stopBodyScroll from './mixins/stopBodyScroll'

let Lang = new Translator({});

Vue.mixin({
    methods: {
        __: function (...args) {
            return Lang.get(...args);
        }
    }
});

new Vue({
    el: '#app',
    components: {
        Popup,
    },

    mixins: [
        stopBodyScroll,
    ],

    data: {
        popupIsActive: false,
    },

    methods: {
        showPopup(name, params = {}) {
            if (this.$refs[name] == undefined)
                return console.error("[Vue/Popup]: Popup '" + name + "' not found")

            this.$refs[name].$emit('show', params)

            this.stopBodyScroll(this.popupIsActive, 'popup-wrapper')
        },
    },
});

