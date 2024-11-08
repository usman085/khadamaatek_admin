const DataTableMixin={
    data(){
        return{
            page:1,
            totalPages:1,
            next:null,
            pageSize:10,
            previous:null,
            items:[],
            count:0
        }
    },
    watch:{
        'page'(){
            this.getItems()
        }
    },

    methods:{
        formQueryParams(){
            return{
                page:this.page
            }
        },
        formalizeTable(response){
            this.page=response.current_page
            this.totalPages=response.total_pages
            this.items=response.results
            this.count=response.count
        }
    }
}
export default DataTableMixin