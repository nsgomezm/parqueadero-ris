<template>
<div>
        <form  v-on:submit.prevent="store" autocomplete="off">
            <h1 v-if="!newCustomer">Actualizar Cliente</h1>
            <div class="form-group">
                <label for="cedula">Cedula</label>
                <input type="text" class="form-control" id="cedula" v-model="customer.cedula" name="cedula" v-validate="'required|numeric'" v-on:blur="cedulaValidate()" :disabled="newCustomer == false" required>
                <span class="text-danger">{{ errors.first('cedula') }}</span>

            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" v-model="customer.name" v-validate="'required'" required>
                <span class="text-danger">{{ errors.first('name') }}</span>
            </div>
            <div class="form-group">
                <label for="name">Apellido</label>
                <input type="text" class="form-control" id="last_name" name="last_name" v-model="customer.last_name" v-validate="'required'" required>
                <span class="text-danger">{{ errors.first('last_name') }}</span>
            </div>
            <div class="form-group">
                <label for="cel">Celular</label>
                <input type="number" class="form-control" id="cel"  name="cel" v-model="customer.cel" v-validate="'numeric'" required>
                <span class="text-danger">{{ errors.first('cel') }}</span>

            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" class="form-control" id="address" name="address" v-model="customer.address" v-validate="'required'" required>
                <span class="text-danger">{{ errors.first('address') }}</span>
            </div>
            <div class="form-group">
                <label for="address">Comentarios</label>
                <textarea name="comments" id="comments" cols="30" rows="3" class="form-control" v-model="customer.comments" v-validate="'max:225'"></textarea>
                <span class="text-danger">{{ errors.first('comments') }}</span>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="status">Parqueadero</label>
                    </div>
                    <select class="custom-select" id="status" name="admin"  v-model="customer.parking_id" v-validate="'required'" required>
                        <option :value="parking.id" v-for="(parking, index) in parkings" :key="index" >
                            {{ parking.name }}
                        </option>
                    </select>
                </div>
                    <span class="text-danger">{{ errors.first('admin') }}</span>
            </div>
            <div class="form-row">
                <div class="form-group col-12 col-md-6" v-if="newCustomer == false">
                    <label for="created_at">Fecha creación</label>
                    <input type="datetime" class="form-control" id="created_at" v-model="customer.created_at" disabled>
                </div>
                <div class="form-group col-12 col-md-6" v-if="newCustomer == false">
                    <label for="updated_at">Ultima actualización</label>
                    <input type="datetime" class="form-control" id="updated_at" v-model="customer.updated_at" disabled>
                </div>
            </div>
            <div class="input-group d-flex justify-content-around align-items-center m-auto my-4" style="max-width: 500px">
                <a href="/Customer">Regresar</a>
                <input type="submit" value="Actualizar" class="btn btn-success">
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props:['data'],
        data(){
            return {
                newCustomer: true,
                parkings: null,
                customer: {
                    cedula: '',
                    name: '',
                    last_name: '',
                    cel: '',
                    address: '',
                    comments: '',
                },
            }
        },
        created(){
            this.getCustomer()
            this.getParking()
        },
        methods:{
            async cedulaValidate(){
                if(this.customer.cedula != '') {
                    await axios.get(`/api/validate/cedul/${this.customer.cedula}`).then(res => {
                        if(!$.isEmptyObject(res.data)){
                            document.getElementById("cedula").focus();
                            this.customer.cedula = '';
                            swal('Identification already been taken');
                        }
                    })
                }
            },
            async getParking(){
                await axios.get(`/api/parking/get/`).then(res => {
                    if(!$.isEmptyObject(res.data)){
                        this.parkings = res.data.parkings
                    }
                })
            },
            getCustomer(){
                if(this.data){
                    this.customer = JSON.parse(this.data),
                    this.newCustomer = false
                }
            },

            async store(){
                try{
                    var url = '/Customer/edit-information/set/'
                    if(this.newCustomer == false){ url += this.customer.id }

                    await axios.post(url, this.customer).then(res => {
                        swal(res.data.title, res.data.menssage, "success")
                        .then(result => {
                            window.location.href = `/Customer/edit-information/${res.data.customer.id}`
                        })
                    })
                }catch(res){
                    swal('No se puedo guardar la información, por favor intenlo nuevamente.')
                }
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
