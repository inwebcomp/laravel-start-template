<template>
    <div class="gallery__load-area"
         @dragover.prevent="over = true"
         @dragleave.prevent="over = false"
         ref="area">

        <label class="gallery__load-area__label w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-sm tracking-wide uppercase border border-grey border-dashed cursor-pointer hover:bg-grey-lighter" :class="{'gallery__load-area--over': over}">
            <svg class="gallery__load-area__icon w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 20 20">
                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
            </svg>

            <span class="gallery__load-area__text mt-2 text-base leading-normal">
                <slot>{{ __('Выберите файл') }}</slot>
            </span>

            <input type='file' class="gallery__load-area__input hidden" multiple @change="load($event.target.files)"/>
        </label>
    </div>
</template>

<script>
    export default {
        name: "LoadArea",

        props: {
            maxSize: {
                type: Number,
                default: 2
            },
        },

        data() {
            return {
                over: false
            }
        },

        created() {
            document.addEventListener('drop', this.drop)
        },

        methods: {
            checkSize(file) {
                if (! file.errors)
                    file.errors = [];

                if (file.size > this.maxSize * 1000000) {
                    file.errors.push(this.__('Max file size is :sizeMB', {size: this.maxSize}))
                    return false
                }

                return true
            },

            drop(event) {
                event.preventDefault()
                this.over = false

                let files = event.dataTransfer.files;

                this.load(files)

                return false
            },

            load(files) {
                [...files].forEach(file => this.checkSize(file))

                this.$emit('load', files)
            }
        },
    }
</script>