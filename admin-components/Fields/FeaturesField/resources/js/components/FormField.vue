<template>
    <default-field :field="field" :errors="errors" :inline="inline" v-bind="other">
        <form-section :field="{ name: __('Список достижений') }"/>

        <template slot="field">
            <div class="field__editor__section mb-4" v-for="(section, $i) in value">
                <div class="flex -mx-4">
                    <div class="w-1/3 mx-4">
                        <form-label>
                            {{ __('Иконка') }}
                        </form-label>
                        <app-select
                                class="mb-2"
                                :search="false"
                                :id="field.attribute"
                                :options="icons"
                                v-model="section.icon"
                                v-bind="extraAttributes"/>
                    </div>

                    <div class="w-2/3 mx-4">
                        <form-label>
                            {{ __('Текст') }}
                        </form-label>

                        <div class="form__group__translatable mb-2">
                                <textarea class="w-full form__group__input mb-2 h-16"
                                          v-model="section.text"></textarea>

                            <div class="form__group__translatable__locale">{{ field.currentLocale }}</div>
                        </div>

                        <div class="form__group__translatable mb-2"
                             v-for="(translatableValue, locale) in field.translatableValues">
                                <textarea class="w-full form__group__input mb-2 h-16"
                                          v-model="translatableValue[$i].text"></textarea>

                            <div class="form__group__translatable__locale">{{ locale }}</div>
                        </div>

                        <!--                        <div class="form__group__translatable mb-2" v-for="(translatableValue, locale) in field.translatableValues">-->
                        <!--                        <textarea-->
                        <!--                                class="w-full form__group__input mb-2 h-16"-->
                        <!--                                v-model="section.text"></textarea>-->
                        <!--                    <textarea-->
                        <!--                            class="form__group__input form__group__input&#45;&#45;textarea w-full h-auto"-->
                        <!--                            :id="field.attribute + ':' + locale"-->
                        <!--                            v-model="field.translatableValues[locale]"-->
                        <!--                            v-bind="extraAttributes"-->
                        <!--                            :class="errorClasses(translationAttribute(locale))">-->
                        <!--                    </textarea>-->
                        <!--                            <div class="form__group__translatable__locale">{{ locale }}</div>-->
                        <!--                        </div>-->
                    </div>
                </div>

                <div class="py-4 px-6 text-center cursor-pointer hover:bg-grey-lighter" @click="remove($i)">
                    <i class="far fa-trash-alt mr-2"></i> {{ __('Удалить') }}
                </div>
            </div>

            <div class="py-4 px-6 text-center cursor-pointer hover:bg-grey-lighter" @click="add">
                <i class="fal fa-plus mr-2"></i> {{ __('Добавить') }}
            </div>
        </template>
    </default-field>
</template>

<script>
    import HandlesValidationErrors from "../mixins/HandlesValidationErrors"
    import FormField from "../mixins/FormField"

    export default {
        mixins: [FormField, HandlesValidationErrors],

        data() {
            return {
                castArray: true,
                icons: [
                    {
                        title: '-- ' + this.__('Выберите значение'),
                        value: '',
                    },
                    {
                        image: '/img/icons/doctor/education.png',
                        title: this.__('Образование'),
                        value: 'education',
                    },
                    {
                        image: '/img/icons/doctor/planning.png',
                        title: this.__('Планирование'),
                        value: 'planning',
                    },
                    {
                        image: '/img/icons/doctor/happy.png',
                        title: this.__('Счастье'),
                        value: 'happy',
                    },
                    {
                        image: '/img/icons/doctor/aid-kit.png',
                        title: this.__('Аптечка'),
                        value: 'aid-kit',
                    }
                ]
            }
        },

        created() {
            this.initTranslations()
        },

        watch: {
            field() {
                this.initTranslations()
            }
        },

        computed: {
            defaultAttributes() {
                return {
                    type: this.field.type || 'text',
                    min: this.field.min,
                    max: this.field.max,
                    step: this.field.step,
                    pattern: this.field.pattern,
                    placeholder: this.field.placeholder,
                }
            },

            extraAttributes() {
                const attrs = this.field.extraAttributes

                return {
                    ...this.defaultAttributes,
                    ...attrs,
                }
            },
        },

        methods: {
            initTranslations() {
                let value = this.field.value
                let translatableValues = this.field.translatableValues

                if (! value)
                    value = []

                Object.keys(translatableValues).forEach((lang) => {
                    if (! translatableValues[lang]) {
                        translatableValues[lang] = []
                    }

                    Object.keys(value).forEach((index) => {
                        if (! translatableValues[lang][index])
                            translatableValues[lang][index] = {
                                icon: (this.hasTranslation(lang) && value[index].icon) || '',
                                text: '',
                            }
                    })
                })
            },

            hasTranslation(lang) {
                if (! this.value)
                    return false

                return !! Object.keys(this.value).find((index) => this.field.translatableValues[lang] && this.field.translatableValues[lang][index] && this.field.translatableValues[lang][index].title)
            },

            add() {
                let newValue = this.field.value ? this.field.value.slice() : []

                newValue.push({
                    icon: '',
                    text: '',
                })

                this.$emit('input', newValue)

                this.initTranslations()
            },

            remove(index) {
                if (!confirm(this.__('Are you sure to delete text section?')))
                    return

                let newValue = this.value.filter((item, i) => index !== i)

                let translatableValues = this.field.translatableValues

                // Object.keys(translatableValues).forEach((lang) => {
                //     this.field.translatableValues[lang] = translatableValues[lang].filter((item, i) => index !== i)
                // })

                this.$emit('input', newValue)
            }
        },
    }
</script>

