App.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'admin-translatable-phrases',
            path: '/admin-translatable-phrases/:selectedLocale?',
            components: {
                default: require('./components/Tool'),
                header: Vue.component('app-header'),
                sidebar: Vue.component('app-sidebar')
            },
            props: {
                default: true
            }
        },
    ])
})
