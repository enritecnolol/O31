<template>
    <tr>
        <td>
            <select class="form-control form-control-sm">
                <option value="01">Comprobante normal</option>
                <option value="01">Gasto menores</option>
            </select>
        </td>
        <td style="width:15%;">
            <money
                    v-model="item.gross"
                    v-bind="money"
                    class="form-control form-control-sm float-right"
                    style="text-align: right"
            />
        </td>
        <td style="width:15%;">
            <money
                    v-model="item.discount"
                    v-bind="money"
                    class="form-control form-control-sm float-right"
                    style="text-align: right"
            />
        </td>
        <td style="width:15%;">
            <money
                    v-model="item.impost"
                    v-bind="money"
                    class="form-control form-control-sm float-right"
                    style="text-align: right"
            />
        </td>
        <td style="width:15%;">
            <money
                    v-model="item.totalNet"
                    v-bind="money"
                    class="form-control form-control-sm float-right"
                    style="text-align: right"
            />
        </td>
    </tr>
</template>

<script>
    export default {
        props:['index', 'item'],
        data()
        {
            return {

                money: {
                    decimal: ".",
                    thousands: ",",
                    prefix: "RD$ ",
                    precision: 2,
                    masked: false
                },
            }
        }
    }
</script>

<style scoped>

</style>
