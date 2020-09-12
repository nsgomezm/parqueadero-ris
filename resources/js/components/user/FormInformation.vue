<template>
    <div>
        <form  v-on:submit.prevent="store">
            <div class="form-group">
                <label for="cedula">Cedula</label>
                <input type="text" class="form-control" id="cedula" v-model="personal_information.cedula" disabled>
            </div>
            <div class="form-row">
                <div class="form-group col-12 col-md-6 ">
                    <label for="name">Nombres completos</label>
                    <input type="text" class="form-control" id="name" v-model="personal_information.name" required>
                </div>
                <div class="form-group col-12 col-md-6" >
                    <label for="last_name">Apellidos completos</label>
                    <input type="text" class="form-control" id="last_name" v-model="personal_information.last_name" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12 col-md-6" >
                    <label for="cel">Celular</label>
                    <input type="number" class="form-control" id="cel" v-model="personal_information.cel" required>
                </div>
                <div class="form-group col-12 col-md-6" >
                    <label for="address">Dirección</label>
                    <input type="text" class="form-control" id="address" v-model="personal_information.address" required>
                </div>
            </div>
            <div class="form-group" >
                <label for="comments">Comentarios</label>
                <textarea id="comments" cols="30" rows="5" class="form-control" v-model="personal_information.comments"></textarea>
            </div>
            <div class="form-row">
                <div class="form-group col-12 col-md-6">
                    <label for="created_at">Fecha creación</label>
                    <input type="datetime" class="form-control" id="created_at" v-model="personal_information.created_at" disabled required>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="updated_at">Ultima actualización</label>
                    <input type="datetime" class="form-control" id="updated_at" v-model="personal_information.updated_at" disabled required>
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
    export default {
        props: ['user'],
        data(){
            return {
                personal_information: this.user
            }
        },
        methods:{
            async store(){
                await axios.post(`/users/edit-information/personal-information/${this.personal_information.id}`, this.personal_information).then(res => {
                    console.log(res.data)
                    swal("Registro actualizadó", "Información personal se actualizó correctamente", "success");
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
