<template>
  <div >
        <date-picker
            v-model="time3"
            :shortcuts="shortcuts"
            :lang="lang"
            range
            confirm
            @confirm="change"
            @input="change"
            @change="change"
            placeholder="Select"
        />
  </div>
</template>
<script>
  import DatePicker from 'vue2-datepicker';
  export default {
    name:'filters_date',
    components:{DatePicker},
    data(){
      return{
        fechainicio:'',
        fechafin:'',
        time3: '',
        // custom lang
        lang: {
          days: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
          months: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dic'],
          pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
          placeholder: {
            date: 'Select Date',
            dateRange: 'Select Date Range'
          }
        },
        shortcuts: [
          {
            text: 'Hoy',
            onClick: () => {
              this.time3 = [ moment().format("YYYY-MM-DD"), moment().format("YYYY-MM-DD") ]
            }
          },
          {
            text: 'Ayer',
            onClick: () => {
              this.time3 = [ moment().subtract(1,'day').format("YYYY-MM-DD") , moment().subtract(1,'day').format("YYYY-MM-DD")]
            }
          },
          {
            text: 'Semana Pasada',
            onClick: () => {
              this.time3 = [ moment().subtract(1,'week').startOf('week').format("YYYY-MM-DD"), moment().subtract(1,'week').endOf('week').format("YYYY-MM-DD")]
            }
          },
          {
            text: 'Mes',
            onClick: () => {
              this.time3 = [ moment().startOf('month').format("YYYY-MM-DD"), moment().endOf('month').format("YYYY-MM-DD")]
            }
          },
          {
            text: 'Mes Pasado',
            onClick: () => {
              this.time3 = [ moment().subtract(1,'month').startOf('month').format("YYYY-MM-DD"), moment().subtract(1,'month').endOf('month').format("YYYY-MM-DD")]
            }
          },
          {
            text: 'Este año',
            onClick: () => {
              this.time3 = [ moment().startOf('year').format("YYYY-MM-DD"), moment().endOf('year').format("YYYY-MM-DD")]
            }
          }
        ],
        type:'date'
      }
    },
    methods:{
      customFormatter(date) {
        return moment(date).format('D MMMM  YYYY');
      },
      change(){
        this.$emit("date_select", {date:this.time3});
      }
    },
    computed:{

    },
    watch:{
      time3()
      {
        this.$emit("date_select", {date:this.time3});
      },
      reset(){
        if(this.reset){
          this.time3 = '';
        }
      }
    }
  }
</script>
<style>
  .inputdate{
    width: 150px;
  }
</style>
