<a href="/favorite/" class="ug_ideal-favorite_counter">
  <i class="fa fa-star" aria-hidden="true"></i>
  <hr>
  {{favoriteCounter}} 
</a>

<script>
  new Vue ({
    el:'.ug_ideal-favorite_counter',

    data: {
      favoriteCounter: 0,
    },

    methods: {
      removeFromFavorite: function () {
        var arr = JSON.parse(localStorage.getItem('ug_ideal_favorite'));
        newArray = [];
        for (var i = 0; i < arr.length; i++) {
          if (arr[i] != this.popUpImageId) {
            newArray.push(arr[i]);
          }
        }
        this.favoriteAddStarIcon = false;
        this.favoriteCounter = newArray.length;
        localStorage.setItem('ug_ideal_favorite', JSON.stringify(newArray));
      },

      addToFavorite: function () {
        this.favoriteAddImage = 'add_to_favorite-active';
        var thisVue = this;
        setTimeout(function () {
          thisVue.favoriteAddImage = 'add_to_favorite';
          var arr = JSON.parse(localStorage.getItem('ug_ideal_favorite'));
          arr.push(thisVue.popUpImageId);
          localStorage.setItem('ug_ideal_favorite', JSON.stringify(arr));
          thisVue.favoriteCounter = arr.length;
          thisVue.favoriteAddStarIcon = true;
        }, 100);
      },
    },

    mounted: function () {
      if (localStorage.getItem('ug_ideal_favorite')) {
        this.favoriteCounter = JSON.parse(localStorage.getItem('ug_ideal_favorite')).length;
      } else {
        localStorage.setItem('ug_ideal_favorite', JSON.stringify([]));
        this.favoriteCounter = 0;
      }
    },
  });

</script>