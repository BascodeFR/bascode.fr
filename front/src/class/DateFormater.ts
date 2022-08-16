export class DateFormater{
     month = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
  "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"
    ];
    sqlDate: Date
    item: string

    constructor(sqlDate: Date, item: string){
        this.sqlDate = sqlDate
        this.item = item

    }

 public sqlToJsDate(): Date{
    return new Date(this.sqlDate);
}




public  getDate(){
    const date =new Date();
    if (date.getFullYear() === this.sqlToJsDate().getFullYear()){
        return this.sqlToJsDate().getDate() + ' ' + this.month[this.sqlToJsDate().getMonth()]
    }
    return this.sqlToJsDate().getDate() + ' ' + this.month[this.sqlToJsDate().getMonth()] + ' ' + this.sqlToJsDate().getFullYear()
}
}