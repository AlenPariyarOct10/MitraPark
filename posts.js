
    let postPlace = document.querySelector('.mid-body');

      console.log("hello\n");
      
      postPlace.innerHTML += `
  
      <div class="post-item">
      <div class="post-item-head">
          <div class="post-item-head-left">
              <img class="profile-picture-holder" src="/MitraPark/alen-profile.jpg" alt="" srcset="">
          </div>
          <div class="post-item-head-right">
              <div class="post-user">
                  <span>Alen Pariyar</span>
              </div>
              <div class="post-details">
                  <span>Public</span>
                  <span>|</span>
                  <span>2023 Oct 10</span>
              </div>
          </div>
      </div>
      <div class="post-item-body">
          <span>Hello World</span>
          <img height="300px" src="./birthday.png" alt="" srcset="">
      </div>
      <div class="post-item-footer">
          <div class="like-container">
              <img height="20px" src="./heart-outline.svg">
              <span>10K</span>
          </div>
          <div class="comment-container">
              <img height="20px" src="./comment-outline.svg">
              <span>1K</span>
          </div>
      </div>
  </div>

`;
