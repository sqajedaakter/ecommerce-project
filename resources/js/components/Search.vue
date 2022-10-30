<template>
    <div class="col-lg-6 col-6 text-left">
        <form action="">
            <div class="input-group">
                <input type="text" name="search" v-model="search" class="form-control"
                    placeholder="Search for products">
                <div class="input-group-append">
                    <span class="input-group-text bg-transparent text-primary">
                        <i class="fa fa-search"></i>
                    </span>
                </div>

                <div class="card-body table-responsive p-0" v-show="isOpen">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in items" :key="item.id">
                                <td>
                                    <img :src="'/public/Image/' + item.image" height="50px" width="50px" alt="">
                                </td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.price }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </form>
    </div>
</template>

<script>

export default {
    name: "Search",
    data() {
        return {
            search: '',
            items: [],
            isOpen: false
        }
    },
    watch: {
        search(after, before) {
            axios.get('/get/search/products/', { params: { search: this.search } })
                .then(response => {
                    if (this.search.length > 0) {
                        this.isOpen = true
                        this.items = response.data
                    } else {
                        this.isOpen = false
                    }
                }).catch(error => {
                    console.log(error)
                })
        }

    },
    mounted() {

    },
    created() {

    },
    methods: {

    }
}
</script>
