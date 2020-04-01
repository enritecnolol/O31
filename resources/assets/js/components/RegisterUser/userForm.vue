<template>
    <form @submit.prevent="save">
      <div class="form-group">
        <label for="name">Nombre</label>
        <input type="text" maxlength="50" class="form-control" id="name" v-model="name">
      </div>
      <div class="form-group">
        <label for="email">Correo Electronico</label>
        <input type="email" class="form-control" id="email" v-model="email">
      </div>
      <div class="form-group">
        <label for="Password">Password</label>
        <input type="password" class="form-control" id="Password" v-model="password">
      </div>
      <div class="form-group">
        <label for="PasswordConfirmation">Password confirmación</label>
        <input type="password" class="form-control" id="PasswordConfirmation" v-model="password_confirmation">
      </div>
      <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Guardar</button>
    </form>
</template>
<script>
  export default {
    components:{
    },
    data()
    {
      return {
        name:'',
        email:'',
        password: '',
        password_confirmation: ''
      }
    },
    methods:{
      save()
      {
        if (this.name === "" || this.email === "" || this.password === "" || this.password_confirmation === "")
        {
          toastr.success('Favor de llenar todos los campos', 'Validador');
          return;
        }

        axios.post('/register/user', {
          name:this.name,
          email:this.email,
          password:this.password,
          password_confirmation:this.password_confirmation
        }).then((response) => {
          toastr.success('El usuario fue correctamente creado', 'Validador');
          this.$emit('close_form')
        })
            .catch((err) => {
              console.log(err)
            })
      }
    },
    created() {

    }
  }
</script>