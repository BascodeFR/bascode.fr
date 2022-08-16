export class UrlBuilder{

    private lim: number |undefined
    private ids: number | undefined
    private ord: string[] | undefined
    host: string
    view: string

    /**
     * @param  {string} host
     * @param  {string} view
     */
    constructor(host: string, view: string){
        this.host = host
        this.view = view
    }
    /**
     * @param  {number} limit
     * @returns this
     */
    public limit(limit: number): this{
        this.lim = limit
        return this
    }
    /**
     * @param  {number} id
     * @returns this
     */
    public id(id: number): this{
        this.ids = id
        return this
    }
    /**
     * @param  {string} key
     * @param  {string} dir
     * @returns this
     */
    order(key: string, dir: string ): this{
        dir = dir.toUpperCase()
        if (dir.includes('DESC, ASC')){
            this.ord = [key];
        } else{
            this.ord = [key, dir];
        }
        return this;
    }


    toUrl(){
        let url = this.host + '/' + this.view
        if(this.ids != undefined){
            url += '?id=' + this.ids
        }
        if(this.ord != undefined && this.ids == undefined){
            url += '?order=' + this.ord[1] + '&field=' + this.ord[0]
        } else if(this.ord != undefined) {
            url += '&order=' + this.ord[1] + '&field=' + this.ord[0]
        }
        if(this.lim != undefined){
             url += '&limit=' + this.lim
        }
        return url
    }
}