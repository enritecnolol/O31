<template>
  <card-panel>
    <template slot="body">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div style="float: left">
              <h3>Lista de usuarios</h3>
            </div>
            <div style="float: right">
              <button
                  class="btn btn-sm"
                  :class="userForm ? 'btn-danger' : 'btn-primary'"
                  @click="userFormStatus(!userForm)">
                <i class="fas"
                   :class="userForm ? 'fa-angle-down' : 'fa-plus'"
                /> {{userForm ? 'Ocultar' : 'Crear usuario'}}
              </button>
            </div>
          </div>
          <template v-if="userForm">
            <div class="col-md-6" style="margin-top: 10px">
              <user-form @close_form="userFormStatus(false)"/>
            </div>
          </template>
          <template v-else>
            <div class="col-md-12" style="margin-top: 20px">
              <general-table>
                <template slot="table-header">
                  <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha creación</th>
                    <th>Estado</th>
                    <th></th>
                  </tr>
                </template>
                <template slot="table-body">
                  <template v-for="(item, index) in usersList">
                    <tr>
                      <td>{{item.name}}</td>
                      <td>{{item.email}}</td>
                      <td>{{moment(item.created_at).format('DD-MM-YYYY, h:mm:ss a')}}</td>
                      <td :class="item.status ? 'paid' : 'overdue'" >{{item.status ? 'Activo' : 'Desactivado'}}</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-sm  btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" onclick="return false;" @click="resetPassword(item.id)">Resetear Contraseña</a>
                            <a class="dropdown-item" href="#" onclick="return false;" @click="disableAccount(item.id)">Inhabilitado cuenta</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </template>
                </template>
              </general-table>
            </div>
          </template>
        </div>
      </div>
    </template>
  </card-panel>
</template>
<script>
  import cardPanel from "../cardPanel";
  import generalTable from "../generalTable";
  import userForm from "./userForm";
  export default {
    components:{
      cardPanel,
      generalTable,
      userForm
    },
    data()
    {
      return {
        usersList:[],
        userForm:false
      }
    },
    methods:{
      userFormStatus(val){
        this.userForm = val;
        if(!val){
          this.fetchData();
        }
      },
      fetchData()
      {
        axios.get('/user/list')
            .then((response) => {
              this.usersList = response.data;
            })
            .catch((err) => {
              console.log(err)
            })
      },
      resetPassword(id){
        var txt;
        var r = confirm("Esta seguro que quiere resetear la contraseña?");
        if (r == true){
          axios.get('/user/password/reset', {
            params:{
              user_id:id
            }
          })
              .then((resp) => {
                toastr.success(resp.data.message, 'Validator');
                this.fetchData();
              })
              .catch((err) => {
                console.log(err)
              })
        }

      },
      disableAccount(id)
      {
        var txt;
        var r = confirm("Estas seguro de deshabilitar esta cuenta ?");
        if (r == true){
          axios.get('/user/disable/account', {
            params:{
              user_id:id
            }
          })
              .then((resp) => {
                toastr.success(resp.data.message, 'Validator');
                this.fetchData()
              })
              .catch((err) => {
                console.log(err)
              })
        }

      }
    },
    created() {
      this.fetchData()
    }
  }
</script>
<style>
  .paid{
    color: #108000;
  }
  .overdue {
    color: #f95700;
  }
</style>