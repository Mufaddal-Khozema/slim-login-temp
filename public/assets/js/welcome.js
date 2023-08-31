Vue.createApp({
  data() {
    return {
      makeParentFocus: false,
    }
  },
  mounted() {
    navigator.geolocation.getCurrentPosition(
      position => {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        alert(`Your location ${latitude},${longitude}`)
      }
    )
  }
}).mount('#app');