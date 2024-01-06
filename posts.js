$.ajax({
  url: "http://localhost/MitraPark/server/api/get-posts.php",
  type: "POST",
  success: (x) => {
    let postPlace = document.querySelector(".mid-body");
    x.forEach((postItem) => {
      postPlace.innerHTML += `
  
      <div class="post-item">
      <div class="post-item-head">
          <div class="post-item-head-left">
              <img class="profile-picture-holder" src="/MitraPark/alen-profile.jpg" alt="" srcset="">
          </div>
          <div class="post-item-head-right">
              <div class="post-user">
                  <span>${postItem.user_first_name+" "+postItem.user_last_name}</span>
              </div>
              <div class="post-details">
                  <span>${postItem.post_visibility}</span>
                  <span>|</span>
                  <span>${postItem.published_date} | ${postItem.published_time}</span>
              </div>
          </div>
      </div>
      <div class="post-item-body">
          <span>${postItem.post_text}</span>
          <img height="300px" src=".${postItem.media_url}" alt="" srcset="">
      </div>
      <div class="post-item-footer">
          <div class="like-container">
              <img height="20px" src="./heart-outline.svg">
              <span>${postItem.post_likes_count}</span>
          </div>
          <div class="comment-container">
              <img height="20px" src="./comment-outline.svg">
              <span>${postItem.post_comments_count}</span>
          </div>
      </div>
  </div>

`;
    });
  },
  error: () => {
    console.log("error");
  },
});

console.log("hello\n");
