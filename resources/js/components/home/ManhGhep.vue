<template>
    <div class="puzzle-container">
      <div class="puzzle-piece" v-for="(piece, index) in puzzlePieces" :key="index" @click="handlePieceClick(index)" :style="{ left: piece.x + 'px', top: piece.y + 'px' }">
        <img :src="piece.image"  />
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        puzzlePieces: [
          { image: '/images/sinhnhat11nam/img_main/nha-thi-dau.png', x: 0, y: 0 },
          { image: '/images/sinhnhat11nam/img_main/nha-thi-dau.png', x: 100, y: 0 },
          { image: '/images/sinhnhat11nam/img_main/nha-thi-dau.png', x: 200, y: 0 },
          // Thêm các mảnh ghép khác với tọa độ x, y tương ứng
        ],
      };
    },
    methods: {
      handlePieceClick(index) {
        // Xử lý logic khi người dùng click vào một mảnh ghép
        // Ví dụ: có thể di chuyển mảnh ghép đến vị trí mới
      },
    },
  };
  </script>
  
  <style scoped>
  .puzzle-container {
    position: relative;
    width: 500px; /* Điều chỉnh kích thước cho phù hợp với bức ảnh ghép */
    height: 500px;
    background-image: url('/images/sinhnhat11nam/img_main/nha-thi-dau.png');
    background-size: cover;
    border: 1px solid #ccc;
  }
  
  .puzzle-piece {
    position: absolute;
    cursor: pointer;
  }
  
  .puzzle-piece img {
    width: 100px; /* Điều chỉnh kích thước cho phù hợp với mảnh ghép */
    height: 50px;
  }
  </style>
  