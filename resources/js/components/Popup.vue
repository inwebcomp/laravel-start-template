<template>
    <transition :name="transition" :duration="duration">
        <div class="popup-wrapper" :class="classMod" v-show="show" @click="$emit('close')">
            <div class="popup-container" @click.stop>
                <div class="popup-content">
                    <slot></slot>
                </div>
            </div>
            <div class="popup-close" @click="$emit('close')"></div>
        </div>
    </transition>
</template>

<script>
import stopBodyScroll from '../mixins/stopBodyScroll'

export default {
    name: 'popup',
    props: {
        transition: {
            default: 'fade'
        },
        duration: {
            default: null
        },
        classMod: {
            default: ''
        }
    },

    mixins: [stopBodyScroll],

    data() {
        return {
            show: false,
            params: {}
        }
    },
    created() {
        let self = this
        self.$on('show', function (params) {
            self.show = true
            self.$root.popupIsActive = true
            self.params = params
        })
        self.$on('close', function () {
            self.show = false
            self.$root.popupIsActive = false
            this.stopBodyScroll(false, 'popup-wrapper')
        })
        self.$root.$on('closePopup', function () {
            self.show = false
            self.$root.popupIsActive = false
            this.stopBodyScroll(false, 'popup-wrapper')
        })
    }
}
</script>
