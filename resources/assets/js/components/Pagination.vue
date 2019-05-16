<template>
    <div class="row">
        <div class="col-6">
            <renderless-laravel-vue-pagination :data="data" :limit="limit" :show-disabled="showDisabled" v-on:pagination-change-page="onPaginationChangePage">
                <ul class="pagination" v-if="computed.total > computed.perPage" slot-scope="{ data, limit, computed, prevButtonEvents, nextButtonEvents, pageButtonEvents }">
                    <li class="page-item pagination-prev-nav" :class="{'disabled': !computed.prevPageUrl}" v-if="computed.prevPageUrl || showDisabled">
                        <a class="page-link" href="#" aria-label="Previous" :tabindex="!computed.prevPageUrl && -1" v-on="prevButtonEvents">
                            <slot name="prev-nav">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </slot>
                        </a>
                    </li>
                    <li class="page-item pagination-page-nav" v-for="(page, key) in computed.pageRange" :key="key" :class="{ 'active': page == computed.currentPage }">
                        <a class="page-link" href="#" v-on="pageButtonEvents(page)">{{ page }}</a>
                    </li>
                    <li class="page-item pagination-next-nav" :class="{'disabled': !computed.nextPageUrl}" v-if="computed.nextPageUrl || showDisabled">
                        <a class="page-link" href="#" aria-label="Next" :tabindex="!computed.nextPageUrl && -1" v-on="nextButtonEvents">
                            <slot name="next-nav">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </slot>
                        </a>
                    </li>
                </ul>
            </renderless-laravel-vue-pagination>
        </div>
        <div class="col-6">
            <div class="text-right dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    На странице
                </a>
                <div id="dropdown-menu" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li v-on:click="$emit('count', 15)" class="dropdown-item" href="">15</li>
                    <li v-on:click="$emit('count', 25)" class="dropdown-item" href="">25</li>
                    <li v-on:click="$emit('count', 50)" class="dropdown-item" href="">50</li>
                    <li v-on:click="$emit('count', 100)" class="dropdown-item" href="">100</li>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import RenderlessLaravelVuePagination from '../../../../node_modules/laravel-vue-pagination/src/RenderlessLaravelVuePagination';

    export default {
        props: {
            data: {
                type: Object,
                default: () => {},
            },
            limit: {
                type: Number,
                default: 10,
            },
            showDisabled: {
                type: Boolean,
                default: false
            },
        },

        methods: {
            onPaginationChangePage (page) {
                this.$emit('pagination-change-page', page);
            }
        },

        components: {
            RenderlessLaravelVuePagination
        }
    }
</script>
