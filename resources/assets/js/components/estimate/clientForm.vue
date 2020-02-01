<template>
  <form @submit.prevent="save">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="nombre" class=" form-control-label">Nombre <span style="color: red">*</span></label>
          <input type="text" v-model="name" id="nombre" placeholder="" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="telefono" class=" form-control-label">Telefono <span style="color: red">*</span></label>
          <input type="text" v-model="phone" id="telefono" placeholder="" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="matricula" class=" form-control-label">Documento<span style="color: red">*</span></label>
          <input type="text" id="matricula" v-model="enrollment" placeholder="" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="email" class=" form-control-label">Email <span style="color: red">*</span></label>
          <input type="text" id="email" placeholder="" v-model="email" class="form-control">
        </div>
      </div>
      <div class="col-md-12">
        <textarea name="editor1" class="form-control" placeholder="Observacion" v-model="observation" id="editor1" rows="5" cols="80">
        </textarea>
      </div>
      <div class="col-md-12">
        <hr>
      </div>
      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
      </div>
    </div>
  </form>
</template>
<script>
  export default {
    data()
    {
      return {
        name:'',
        phone:'',
        enrollment:'',
        email:'',
        observation:''
      }
    },
    methods:{
      save()
      {
        if(this.name == "" || this.phone == "" || this.email == "" || this.enrollment == "" || this.observation == "")
        {
          toastr.warning('Revisar los campos obligatorio');
          return;
        }
        axios.post('/clientes/store', {
          nombre: this.name,
          telefono: this.phone,
          email: this.email,
          matricula: this.enrollment,
          observacion: this.observation
        })
            .then( (response) => {
                toastr.success('El cliente ha sido ingresado con exito');
                this.reset();
                this.$emit('hideForm');
            })
            .catch( (error) => {
              toastr.warning('Se ha prodcido un error');
              console.log(error);
            });
      },
      reset()
      {
        Object.assign(this.$data,{
          name:'',
          phone:'',
          enrollment:'',
          email:'',
          observation:''
        });
      }
    }
  }
</script>
<style>

</style>