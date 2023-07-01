<template>
  <div class="about">
    <h1>Admin Page</h1>
    <hr>
    <div class="info"></div>
    <div class="row">
      <div class="col pr-4 me-4" style="border-right: 1px solid gainsboro">
        <div v-if="editId > 0">
          <form @submit.prevent="update(editId)">
            <div class="mb-3">
              <label for="nama" class="form-label">Nama Produk</label>
              <input type="text" class="form-control" id="nama" v-model="nama">
            </div>
            <div class="mb-3">
              <label for="nama" class="form-label">Deskripsi</label>
              <textarea class="form-control" id="nama" v-model="desc"></textarea>
            </div>
            <div class="mb-3">
              <label for="foto" class="form-label">Foto</label>
              <input type="file" class="form-control" id="foto" @change="e => foto = e.target.files[0]">
            </div>
            <div class="mb-3">
              <label for="harga" class="form-label">Harga</label>
              <input type="number" class="form-control" id="harga" v-model="harga">
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
          </form>
        </div>
        <div v-else>
          <form @submit.prevent="add()">
            <div class="mb-3">
              <label for="nama" class="form-label">Nama Produk</label>
              <input type="text" class="form-control" id="nama" v-model="nama">
            </div>
            <div class="mb-3">
              <label for="nama" class="form-label">Deskripsi</label>
              <textarea class="form-control" id="nama" v-model="desc"></textarea>
            </div>
            <div class="mb-3">
              <label for="foto" class="form-label">Foto</label>
              <input type="file" class="form-control" id="foto" @change="e => foto = e.target.files[0]">
            </div>
            <div class="mb-3">
              <label for="harga" class="form-label">Harga</label>
              <input type="number" class="form-control" id="harga" v-model="harga">
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
          </form>
        </div>
      </div>
      <div class="col">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Produk</th>
              <th scope="col">Deskripsi</th>
              <th scope="col">Foto</th>
              <th scope="col">Harga</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data, index) in datas" :key="data.id">
              <th scope="row">{{ index + 1 }}</th>
              <td>{{ data.nama }}</td>
              <td>{{ data.desc }}</td>
              <td>
                <img :src="'http://localhost:8000/images/' + data.foto" :alt="data.nama">
              </td>
              <td>{{ data.harga }}</td>
              <td>
                <button class="btn btn-success me-2" @click="edit(data.id)"><i class="fa-solid fa-square-plus"></i></button>
                <button class="btn btn-outline-danger" @click="del(data.id)"><i class="fa-solid fa-trash-can"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import axios from "axios";

export default {
  name: 'AdminView',
  data(){
    return {
      datas : [],
      editId : null,
      nama: '',
      desc: '',
      foto: null,
      harga: 0,
    }
  },
  mounted(){
    return axios.get('http://localhost:8000/api/products/list')
      .then(res => {
        this.datas = res.data.data
      })
  },
  methods: {
    list(){
      axios.get('http://localhost:8000/api/products/list')
        .then(res => {
          this.datas = res.data.data
        })
    },
    add(){
      let formData = new FormData();

      formData.append('nama', this.nama)
      formData.append('desc', this.desc)
      formData.append('foto', this.foto)
      formData.append('harga', this.harga)

      axios.post('http://localhost:8000/api/products/add', formData, {
        Headers: {'Content-Type': 'multipart/form-data'}
      })
        .then((res) => {
          this.list()
          this.nama = ''
          this.desc = ''
          this.foto = null
          this.harga = 0

          document.querySelector('.info').innerHTML = `
            <div class="alert alert-success" role="alert">
              ${res.data.message}
            </div>`
        })
    },
    del(id){
      axios.delete('http://localhost:8000/api/products/delete/' + id)
        .then(res => {
          this.list()

          document.querySelector('.info').innerHTML = `
            <div class="alert alert-danger" role="alert">
              ${res.data.message}
            </div>`
        })

    },
    edit(id){
      axios.get('http://localhost:8000/api/products/show/' + id)
        .then(res => {
          this.editId = id
          this.nama = res.data.data.nama
          this.desc = res.data.data.desc
          this.harga = res.data.data.harga
        })
    },
    update(id){
      let formData = new FormData();

      formData.append('nama', this.nama)
      formData.append('desc', this.desc)
      formData.append('foto', this.foto)
      formData.append('harga', this.harga)

      axios.post('http://localhost:8000/api/products/edit/' + id, formData, {
        Headers: {'Content-Type': 'multipart/form-data'}
      })
        .then((res) => {
          this.list()
          this.nama = ''
          this.desc = ''
          this.foto = null
          this.harga = 0

          this.edit = 0

          document.querySelector('.info').innerHTML = `
            <div class="alert alert-warning" role="alert">
              ${res.data.message}
            </div>`
        })
    },
  }
}

</script>

<style scoped>
  img {
    width: 60px;
  }
</style>