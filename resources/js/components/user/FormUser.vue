<template>
    <div>
        <form  v-on:submit.prevent="store" autocomplete="off">
            <div class="form-group">
                <label for="nickname">Usuario</label>
                <input type="text" class="form-control" id="nickname" v-model="data.nickname" required>
            </div>
            <div class="form-group">
                <label for="email">Correo electronico</label>
                <input type="email" class="form-control" id="email" v-model="data.email">
            </div>
            <div class="form-group" v-if="newUser == true">
                <label for="emailConfirm">Confirmar electronico</label>
                <input type="email" class="form-control" id="emailConfirm" v-model="data.email">
            </div>
            <div class="form-group" v-if="newUser == true">
                <label for="passwordactual">Contraseña</label>
                <input type="password" class="form-control" id="passwordactual" v-model="data.password">
            </div>
            <div class="form-group" v-if="newUser == true">
                <label for="passwordconfirm">confirmar contraseña</label>
                <input type="password" class="form-control" id="passwordconfirm">
            </div>
            <div class="form-group" v-if="newUser == false">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="status">Rol</label>
                    </div>
                    <select class="custom-select" id="status" v-model="data.roles[0].name">
                        <option value="S.Admin">Super Administrador</option>
                        <option value="Admin">Adminsitrador</option>
                        <option value="patio">Patio</option>
                    </select>
                </div>
            </div>
            <div class="form-group" >
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="status">Estado</label>
                    </div>
                    <select class="custom-select" id="status" v-model="data.status">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12 col-md-6" v-if="newUser == false">
                    <label for="created_at">Fecha creación</label>
                    <input type="datetime" class="form-control" id="created_at" v-model="data.created_at" disabled>
                </div>
                <div class="form-group col-12 col-md-6" v-if="newUser == false">
                    <label for="updated_at">Ultima actualización</label>
                    <input type="datetime" class="form-control" id="updated_at" v-model="data.updated_at" disabled>
                </div>
            </div>
            <div class="input-group d-flex justify-content-around align-items-center m-auto my-4" style="max-width: 500px">
                <a href="/users/list">Regresar</a>
                <input type="submit" value="Actualizar" class="btn btn-success">
            </div>
        </form>
    </div>
</template>

<script>
    var moment = require('moment')

    export default {
        props:['user'],
        data() {
            return {
                newUser: true,
                data: [ ],
            }
        },
        created(){
            this.getUser()
        },
        methods:{
            async getUser(){
                if(this.user){
                    this.data = this.user
                    this.newUser = false
                }
            },

            async store(){
                var url = '/users/edit-information/user/'
                if(this.newUser == false){ url += this.data.id }

                // No funciona para crear un usuario
                await axios.post(url, this.data).then(res => {
                    swal(res.data.title, res.data.menssage, "success");
                })
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>
