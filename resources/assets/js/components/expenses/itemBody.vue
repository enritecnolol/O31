<template>
    <tr>
        <td>
            <select class="form-control form-control-sm">
                <option value="01">Comprobante normal</option>
            </select>
        </td>
        <td style="width:15%;"><input type="text" class="form-control form-control-sm"></td>
        <td style="width:15%;"><input type="text" class="form-control form-control-sm"></td>
        <td style="width:15%;"><input type="text" class="form-control form-control-sm"></td>
        <td style="width:15%;"><input type="text" class="form-control form-control-sm"></td>
    </tr>
</template>

<script>
    export default {
        props:['index', 'item']
    }
</script>

<style scoped>

</style>
