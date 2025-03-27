<template>


    <draggable :list="booksNew" v-bind="{animation:300, handle:'.drag'}"  v-bind:style="{ 'width': wdth }" :element="'div'" @change="update()">
        <div v-for="(book, index) in booksNew" class="row mb-1 p-1 block_list" style="margin-right: 5px;"  v-bind:style="{ 'float': flt }" :data-rowId="index">
            <div class="col-1 drag" v-bind:style="{ 'display': show }">
                <span style="font-size:20px;">{{ book.pivot.order }} <i class="bi bi-arrows-move"></i></span><br>
                <button @click="toggle()" class="btn btn-primary">{{ 'compact' }}</button>
            </div>
            <div class="col-10" v-bind:style="{ 'display': show }">
                <div style="float: left; margin: 0 10px" class="nocompact" v-bind:style="{ 'display': show }">
                    <a :href='book.id'>
                    <img :src='book.image' style='max-width:150px' class="compact">
                    </a>
                </div>
                <a :href='book.id' class='h3' style='color:#000000'>{{ book.title }}</a> - {{ book.author }}
                <div>{{ 'Quote:' }} {{ book.pivot.quote }}</div>
                <div>{{ 'Review:' }} {{ book.pivot.review }}</div>
                <div v-if="book.pivot.related != null">{{ 'Suggested books:' }} {{ book.pivot.related }}</div><!-- ++++ SISTEMARE +++++++ -->
            </div>
            <div class="col-1" v-bind:style="{ 'display': show }">
                <a :href="book.id + '/edit'">
                    <button class="btn btn-primary">{{ 'EDIT' }}</button>
                </a>
            </div >
            <div class="drag" id="compact" style="width:fit-content" v-bind:style="{ 'display': hide }">
                <span style="font-size:20px;">{{ book.pivot.order }} <i class="bi bi-arrows-move"></i></span>&nbsp;
                {{ book.title }} - {{ book.author }}&nbsp;
                <button @click="toggle()" class="btn btn-primary">{{ 'expand' }}</button>
            </div>
        </div>
    </draggable>


</template>
<script>
import draggable from 'vuedraggable'

export default {
    components: {
        draggable
    },
    props: ['books'],
    mounted() {
        console.log('Component mounted. ')
    },
    data() {
        return{
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            booksNew: this.books,
            compact: false,
            show: 'block',
            hide: 'none',
            wdth: '100%',
            flt: 'none',
        }
    },
    methods: {
        update(){
            console.log('update!');
            this.booksNew.map((book, index) => {
                book.pivot.order = index + 1;
            })

            axios.patch(
                '/books/updateCustomerSort',
                {booksNew: this.booksNew})
                .then(response => {
                //this.data = response.data.items;
            })
        },
        toggle(){
            console.log('toggle');
            this.compact = !this.compact;
            if(this.show == 'block'){
                this.show = 'none';
                this.wdth = 'fit-content';
                this.flt  = 'left';
                this.hide = 'block';
            } else {
                this.show = 'block';
                this.wdth = '100%';
                this.flt  = 'none';
                this.hide = 'none';
            }

        }
    }
}
</script>
