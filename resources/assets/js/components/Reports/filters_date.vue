<template>
    <div class="col">
        <div class="card border-primary mb-3" style="max-width: 100%;">
            <div class="card-body text-primary">
                <h5 class="card-title">Fecha</h5>
                <hr style=" background:#007bff;">
                <date-picker
                    v-model="time3"
                    :range="selected!=='607'"
                    :type="type"
                    :shortcuts="shortcuts"
                    :lang="lang"
                    confirm
                    @confirm="change"
                    @input="change"
                    @change="change"
                    placeholder="Select"
                    format="YYYY-MM"
                />
            </div>
        </div>
    </div>
</template>
<script>
    import DatePicker from 'vue2-datepicker';
    export default {
        props:['reset', 'selected'],
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
                            this.time3 = [ moment(), moment() ]
                        }
                    },
                    {
                        text: 'Ayer',
                        onClick: () => {
                            this.time3 = [ moment().subtract(1,'day'), moment().subtract(1,'day')]
                        }
                    },
                    {
                        text: 'Semana Pasada',
                        onClick: () => {
                            this.time3 = [ moment().subtract(1,'week').startOf('week'), moment().subtract(1,'week').endOf('week')]
                        }
                    },
                    {
                        text: 'Mes',
                        onClick: () => {
                            this.time3 = [ moment().startOf('month'), moment().endOf('month')]
                        }
                    },
                    {
                        text: 'Mes Pasado',
                        onClick: () => {
                            this.time3 = [ moment().subtract(1,'month').startOf('month'), moment().subtract(1,'month').endOf('month')]
                        }
                    },
                    {
                        text: 'Este año',
                        onClick: () => {
                            this.time3 = [ moment().startOf('year'), moment().endOf('year')]
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
        },
        created() {
            if(this.selected === '607')
            {
                this.type = 'month'
            }
        }
    }
</script>
<style>
    .inputdate{
        width: 150px;
    }
</style>