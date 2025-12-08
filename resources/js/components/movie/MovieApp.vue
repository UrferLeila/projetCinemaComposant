<template>
  <div class="movie-program">
    <h2 class="title-small">Programme du jour</h2>
    <div class="container image-container">
      <div class="item" v-for="(movie, index) in movies" :key="index">
        <img :src="movie.image" />
        <div class="info">
          <h3>{{ movie.date }}</h3>
          <h3>{{ movie.time }}</h3>
        </div>
        <button class="btn-red reserved" @click="goToReservation">Réserver</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      movies: [
        {
          image: "https://themonitormmc.com/wp-content/uploads/2021/01/twilight.jpg",
          date: "02.12.2025",
          time: "09h00",
        },
        {
          image:
            "https://2.bp.blogspot.com/-nFIkDeTR2y8/Td5xcLwz1hI/AAAAAAAAAFU/pVi-pZrqsyQ/s1600/Twilight_IllusCompan_CVR_FINAL.jpg",
          date: "02.12.2025",
          time: "09h00",
        },
        {
          image:
            "https://wallpapers.com/images/hd/jurassic-world-active-volcano-5az4as7ou6azluuj.jpg",
          date: "02.12.2025",
          time: "09h00",
        },
        {
          image: "https://tse3.mm.bing.net/th/id/OIP.9nucBRZfBWPZoPAhI2wVrAHaJ4",
          date: "02.12.2025",
          time: "09h00",
        },
        {
          image: "https://fr.web.img5.acsta.net/pictures/14/08/04/15/09/405662.jpg",
          date: "02.12.2025",
          time: "09h00",
        },
      ],
    };
  },
  methods: {
    goToReservation() {
      this.$router.push("/reservation");
    },
  },
};
</script>
