<template>
    <div>
        <form  v-on:submit.prevent="store" autocomplete="off">
            <h1 v-if="!newParking">Actualizar parqueadero</h1>
            <div class="form-group">
                <label for="nit">Nit</label>
                <input type="text" class="form-control" id="nit" v-model="parking.nit" required>
            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" v-model="parking.name" required>
            </div>
            <div class="form-group">
                <label for="cel">Celular</label>
                <input type="number" class="form-control" id="cel" v-model="parking.cel">
            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" class="form-control" id="address" v-model="parking.address">
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="status">Administrador</label>
                    </div>
                    <select class="custom-select" id="status" v-model="parking.user_id">
                        <option :value="user.id" v-for="(user, index) in users" :key="index">
                            {{ user.personal_information.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12 col-md-6" v-if="newParking == false">
                    <label for="created_at">Fecha creación</label>
                    <input type="datetime" class="form-control" id="created_at" v-model="parking.created_at" disabled>
                </div>
                <div class="form-group col-12 col-md-6" v-if="newParking == false">
                    <label for="updated_at">Ultima actualización</label>
                    <input type="datetime" class="form-control" id="updated_at" v-model="parking.updated_at" disabled>
                </div>
            </div>
            <div class="input-group d-flex justify-content-around align-items-center m-auto my-4" style="max-width: 500px">
                <a href="/Parking/list">Regresar</a>
                <input type="submit" value="Actualizar" class="btn btn-success">
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        data(){
            return {
                newParking: true,
                users: null,
                parkings: null,
                parking: {
                    nit: '',
                    name: '',
                    cel: '',
                    address: '',
                    user_id: '',
                }
            }
        },
        created(){
            this.getParking()
            this.getAdmins()
        },
        methods:{
            async store(){
                var url = '/Parking/edit-information/set/'
                if(this.newParking == false){ url += this.parking.id }

                // No funciona para crear un usuario
                await axios.post(url, this.parking).then(res => {
                    if(this.newParking == true){
                        this.$emit('parkings', res.data.parkings)
                    }
                    swal(res.data.title, res.data.menssage, "success");
                })
            },
            async getParking(){
                if(this.data){
                    this.parking = this.data,
                    this.newParking = false
                }
            },
            async getAdmins(){
                await axios.get('/api/admins/get', this.parking).then(res => {
                    this.users =  res.data.users
                    console.log(res.data)
                })
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>
