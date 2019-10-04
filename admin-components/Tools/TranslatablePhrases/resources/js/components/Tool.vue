<template>
    <div class="p-8">
        <app-button small type="accent" class="float-right" @click.native="parsePhrases">
            {{ this.parsing ? __('Parsing ...') : __('Parse phrases') }}
        </app-button>

        <div class="float-right mr-4 flex">
            <form-label class="float-left mr-2" style="margin-top: .6rem">{{ __('Language') }}:</form-label>
            <app-select small :search="false" :options="allLocales" :value="selectedLocale" @input="changeLanguage"/>
        </div>

        <heading class="mb-6">
            {{ __('Phrases Translations') }} <span v-if="selectedLocale" class="capitalize">{{ '(' + selectedLocale + ')' }}</span>
        </heading>

        <card>
            <template v-if="loading">
                <loading-view></loading-view>
            </template>
            <template v-if="! loading">

                <div class="editable-list bg-white shadow-md rounded">
                    <table class="text-left w-full border-collapse">
                        <thead>
                            <tr>
                                <th v-for="(item, $i) of [__('Original'), __('Translation')]" :key="$i"
                                    class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light" v-html="item">
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(translations, original) in phrases" :key="original" class="hover:bg-grey-lighter">
                                <td class="py-4 px-6 border-b border-grey-light w-1/2">{{ original }}</td>
                                <td class="py-1 px-6 border-b border-grey-light w-1/2">
                                    <div class="pl-8 relative my-2" v-for="(phrase, locale) in translations">
                                        <form-label :labelFor="phrase + locale" class="capitalize absolute pin-l font-normal"
                                                    v-if="! selectedLocale">{{ locale }}
                                        </form-label>
                                        <text-input
                                                :id="phrase + locale" :value="phrase" full small
                                                @blur="save(locale, original, $event.target.value)"/>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="! Object.keys(phrases).length" class="flex justify-center items-center px-6 py-8">
                    <div class="text-center">
                        <svg class="mb-3" xmlns="http://www.w3.org/2000/svg" width="65" height="51" viewBox="0 0 65 51">
                            <g id="Page-1" fill="none" fill-rule="evenodd">
                                <g id="05-blank-state" fill="#A8B9C5" fill-rule="nonzero"
                                   transform="translate(-779 -695)">
                                    <path id="Combined-Shape"
                                          d="M835 735h2c.552285 0 1 .447715 1 1s-.447715 1-1 1h-2v2c0 .552285-.447715 1-1 1s-1-.447715-1-1v-2h-2c-.552285 0-1-.447715-1-1s.447715-1 1-1h2v-2c0-.552285.447715-1 1-1s1 .447715 1 1v2zm-5.364125-8H817v8h7.049375c.350333-3.528515 2.534789-6.517471 5.5865-8zm-5.5865 10H785c-3.313708 0-6-2.686292-6-6v-30c0-3.313708 2.686292-6 6-6h44c3.313708 0 6 2.686292 6 6v25.049375c5.053323.501725 9 4.765277 9 9.950625 0 5.522847-4.477153 10-10 10-5.185348 0-9.4489-3.946677-9.950625-9zM799 725h16v-8h-16v8zm0 2v8h16v-8h-16zm34-2v-8h-16v8h16zm-52 0h16v-8h-16v8zm0 2v4c0 2.209139 1.790861 4 4 4h12v-8h-16zm18-12h16v-8h-16v8zm34 0v-8h-16v8h16zm-52 0h16v-8h-16v8zm52-10v-4c0-2.209139-1.790861-4-4-4h-44c-2.209139 0-4 1.790861-4 4v4h52zm1 39c4.418278 0 8-3.581722 8-8s-3.581722-8-8-8-8 3.581722-8 8 3.581722 8 8 8z"/>
                                </g>
                            </g>
                        </svg>

                        <h3 class="text-base text-80 font-normal mb-6">
                            {{__("No translatable phrases")}}
                        </h3>

                        <app-button small type="accent" @click.native="parsePhrases">
                            {{ __('Parse phrases') }}
                        </app-button>
                    </div>
                </div>
            </template>
        </card>
    </div>
</template>

<script>
    const root = 'tool/translatable-phrases'

    export default {
        props: {
            selectedLocale: {
                type: String,
                default: ''
            }
        },

        data: function () {
            return {
                loading: true,
                parsing: false,
                phrases: {},
                locales: [],
            }
        },
        mounted() {
            this.fetch()
        },

        watch: {
            selectedLocale() {
                this.fetch()
            }
        },

        methods: {
            async fetch() {
                let self = this
                self.loading = true
                App.api.request({
                    url: root + '' + (self.selectedLocale ? '/' + self.selectedLocale : '')
                }).then(data => {
                    self.phrases = data.phrases
                    self.locales = data.locales
                    self.loading = false
                })
            },

            parsePhrases() {
                let self = this
                self.loading = true
                self.parsing = true
                App.api.request({
                    method: 'post',
                    url: root + '/parse'
                }).then(data => {
                    self.$toasted.show(data.message, {type: 'success'})
                    self.fetch()
                    self.loading = false
                    self.parsing = false
                })
            },

            save(locale, original, phrase) {
                let self = this

                if (self.phrases[original][locale] == phrase)
                    return

                App.api.request({
                    method: 'post',
                    url: root + '/save',
                    data: {
                        locale,
                        original,
                        phrase
                    }
                }).then(data => {
                    self.$toasted.show(data.message, {type: 'success'})
                    self.phrases[original][locale] = phrase
                })
            },

            changeLanguage(locale) {
                if (locale)
                    this.$router.push({name: 'admin-translatable-phrases', params: {selectedLocale: locale}})
                else
                    this.$router.push({name: 'admin-translatable-phrases'})
            }
        },

        computed: {
            allLocales() {
                let list = [
                    {
                        value: '',
                        title: this.__('All'),
                    }
                ]

                this.locales.forEach(locale => {
                    list.push({
                        value: locale,
                        title: locale,
                    })
                })

                return list
            }
        },
    }
</script>
