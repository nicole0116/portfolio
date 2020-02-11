new Vue({
  el: "#calendar",
  data() {
    return {
      handcalendar_today:{
        year:0,
        month:0,
        date:0,
        day:0
      },
      calendar:{
        year:0,
        month:0,
        date:0,
        day:0,
        week:["January", "February", "March", "April", "May", "June", "July","August","Septemper","October","November","December"][new Date().getMonth()],
       
      }
    };
  },
  mounted(){
    this.setToday()
  },
  methods:{
    setToday(){
      // console.log("123");
      const date = new Date()
      this.handcalendar_today.year = this.calendar.year = date.getFullYear()
      this.handcalendar_today.month = this.calendar.month = date.getMonth() // 0~11
      this.handcalendar_today.date = this.calendar.date = date.getDate()
      this.handcalendar_today.day = this.calendar.day = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"][date.getDay()]
      this.calendar.week=["January", "February", "March", "April", "May", "June", "July","August","Septemper","October","November","December"][new Date().getMonth()]
    console.log( date.getFullYear())
    console.log( this.handcalendar_today.month)
    console.log(this.handcalendar_today.date)

    },
    adjustYear(fix){
      this.calendar.year += fix
    },
    adjustMonth(fix){
      // this.calendar.month += fix 範圍
      let month = this.calendar.month + fix
      // let engeng_month
      if(month > 11){
        this.adjustYear(1)
        this.calendar.month = 0
         this.calendar.week=["January", "February", "March", "April", "May", "June", "July","August","Septemper","October","November","December"][0]
      }else if(month < 0){
        this.adjustYear(-1)
        this.calendar.month = 11
        this.calendar.week=["January", "February", "March", "April", "May", "June", "July","August","Septemper","October","November","December"][11]
        // this.calendar.eng_month=11
      }else{
        this.calendar.month = month
        this.calendar.week=["January", "February", "March", "April", "May", "June", "July","August","Septemper","October","November","December"][month]
      }

    }
  },
  computed:{
  
    calendarFirstDay(){
      const mDate = new Date(this.calendar.year,this.calendar.month,1)
      const date = new Date(this.calendar.year,this.calendar.month,1 - mDate.getDay())
      return {
        year:date.getFullYear(),
        month:date.getMonth(),
        date:date.getDate(),
        day:["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"][date.getDay()],
       
      }
    },
    calendarMonth(){
      const data = []
      let date
      for(let i=0;i<42;i++){
        date = new Date(this.calendarFirstDay.year,this.calendarFirstDay.month,this.calendarFirstDay.date + i)
        data.push({
          year:date.getFullYear(),
          month:date.getMonth(),
          date:date.getDate(),
          day:["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"][date.getDay()],
          programdate:[date.getFullYear(),date.getMonth(),date.getDate()]
        })
      }
      return data
    }

  }
})