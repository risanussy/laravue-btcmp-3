<template>
  <div class="home">
    <h1>Products</h1>
    <hr>
    <div class="d-flex produk">
      <div v-for="data in datas" :key="data.id">
        <div class="card shadow" style="width: 18rem;">
          <div class="cover">
            <img :src="'http://localhost:8000/images/' + data.foto" class="card-img-top" :alt="data.nama">
          </div>
          <div class="card-body">
            <h5 class="card-title">{{ data.nama }}</h5>
            <small>{{ data.harga }}</small>
            <p class="card-text">{{ data.desc }}</p>
            <a href="#" class="btn btn-primary">detail</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import axios from "axios";

export default {
  name: 'HomeView',
  data(){
    return {
      datas : []
    }
  },
  mounted(){
    return axios.get('http://localhost:8000/api/products/list')
      .then(res => {
        this.datas = res.data.data
      })
  }
}
</script>

<style>
  .produk {
    justify-content: start;
    gap: 10px;
    flex-wrap: wrap;
  }

  .cover {
    width: 100%;
    height: 150px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
  }
</style>
