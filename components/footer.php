</main>

<template id="chatbox-template">
  <div class="chatbox">
    <img src="../../assets/images/speechbbl.png" class="">
    <div class="chatbox-area"></div>
  </div>
</template>

<style>
  .chatbox img {
    width: 300px;
    transform: scaleX(-1);
  }

  .chatbox {
    position: fixed;
    bottom: 65px;
    right: -25px;
    pointer-events: none;
  }

  .chatbox-area {
    position: absolute;
    top: 56px;
    left: 30px;
  }
</style>
<!-- bootstrap js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.bundle.min.js"></script>
<!-- jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  let villagerImage = document.querySelector('.villager');
  if (!villagerImage) {
    villagerImage = document.querySelector('.villager2');
  }
  villagerImage.addEventListener("click", function() {
    let villagerSounds = [
      "hmm1.mp3",
      "hmm2.mp3",
      "hmm3.mp3"
    ];
    let villagerText = [
      "Mau buku apa?",
      "Ada yang bisa saya bantu?",
      "Selamat datang!",
    ]
    var snd = new Audio("../../assets/audio/" + villagerSounds[Math.floor(Math.random() * villagerSounds.length)]);
    snd.play();

    let chatbox = document.getElementById('chatbox-template').content.cloneNode(true).children[0];
    chatbox.querySelector(".chatbox-area").innerHTML = villagerText[Math.floor(Math.random() * villagerText.length)];
    document.body.appendChild(chatbox);
    setTimeout(() => {
      chatbox.remove();
    }, 1000);
  })
</script>
</body>

</html>