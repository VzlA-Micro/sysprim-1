// (function () {
//   var uploader = document.getElementById('image'),
//     image = document.getElementById('img-result');
//   uploader.accept = 'image/*';

//   image.onclick = function() {
//     uploader.click();
//   }

//   uploader.onchange = function() {
//     var reader = new FileReader();
//     reader.onload = function(evt) {
//       image.classList.remove('no-image');
//       image.style.backgroundImage = 'url(' + evt.target.result + ')';
//       // var request = {
//       //   itemtype: 'test 1',
//       //   brand: 'test 2',
//       //   images: [{
//       //     data: evt.target.result
//       //   }]
//       // };
      

//       document.querySelector('.show-button').style.display = 'block';
//       // document.querySelector('.upload-result__content').innerHTML = JSON.stringify(request, null, '  ');
//     }
//     reader.readAsDataURL(uploader.files[0]);
//   }
  
//   document.querySelector('.hide-button').click = function () {
//     document.querySelector('.upload-result').style.display = 'none';
//   };
  
//   document.querySelector('.show-button').click = function () {
//     document.querySelector('.upload-result').style.display = 'block';
//   };
// })();