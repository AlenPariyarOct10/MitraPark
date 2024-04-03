
function timeAgo(postedTime) {
  const postedDate = new Date(postedTime);
  const currentDate = new Date();
  const timeDifference = currentDate - postedDate;

  const seconds = Math.floor(timeDifference / 1000);
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);
  const months = Math.floor(days / 30);
  const years = Math.floor(days / 365);

  if (years > 0) {
      return `${years} year${years > 1 ? 's' : ''} ago`;
  } else if (months > 0) {
      return `${months} month${months > 1 ? 's' : ''} ago`;
  } else if (days > 0) {
      return `${days} day${days > 1 ? 's' : ''} ago`;
  } else if (hours > 0) {
      return `${hours} hour${hours > 1 ? 's' : ''} ago`;
  } else if (minutes > 0) {
      return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
  } else {
      return 'just now';
  }
}


async function fetchPosts() {
  return new Promise((resolve, reject) => {
      $.ajax({
          url: "./server/api/posts/get-posts.php",
          type: "POST",
          success: (data) => {
       
              resolve(JSON.parse(data));
          },
          error: (error) => {
     
              reject(error);
          }
      });
  });
}


  

function likeHandeler() {
  let postLikes = document.querySelectorAll(".like-container");
  
  postLikes.forEach((item) => {
      item.addEventListener("click", () => {
          let id = item.dataset.id;
          let src = item.childNodes[1].src;
          let likeCount = item.childNodes[3];

          if (src.includes("assets/images/heart.png")) {
              likeCount.innerHTML = parseInt(likeCount.innerHTML) - 1;
            
              item.childNodes[1].src = "./assets/images/heart-outline.png";
          } else {
              likeCount.innerHTML = parseInt(likeCount.innerHTML) + 1;
          
              item.childNodes[1].src = "./assets/images/heart.png";
          }

          $.ajax({
              url: "./server/api/addLike.php",
              type: "POST",
              data: { postId: id },
              success: (msg) => {
                  console.log(msg);

              },
              error: (msg) => {
                  console.log(msg);
                  localStorage.getItem("mp-uid");
              }
          });
      })
      console.log(item);
  })
}
  
  async function renderPosts() {
    try {
      const postData = await fetchPosts();
      const postPlace = document.querySelector(".mid-body");
      console.log(postData.length);
      if(postData.length > 0)
      {

        postData.forEach(postItem => {

          if(postItem.profile_picture == null)
          {
            postItem.profile_picture = "/MitraPark/assets/images/user.png";
          }
          $.ajax({
            url: "./server/api/getLikes.php",
            type: "POST",
            data: {postId: postItem.post_id},
            success: function(data)
            {
              let likesObj = JSON.parse(data);
              console.log("likes",likesObj);
              let liked_byObj= likesObj.map((item)=>item.liked_by);
              console.log(liked_byObj);

              let likedState = (liked_byObj.indexOf(localStorage.getItem("mp-uid")) != -1)?"./assets/images/heart.png":"./assets/images/heart-outline.png";
              console.log("index",likedState);
              generatePostHTML(postItem, likedState);
            },
            error: function(data)
            {
              console.log("failed");
            }
          })
           
        });

        
      }else{
        postPlace.innerHTML += "No Posts";
      }
      
    } catch (error) {
      console.error("Error fetching or rendering posts:", error);
    }
  }

 


// Each Post Card parameters(postId, likedState)
function generatePostHTML(postItem, likedState) {
  const postHTML = `
            <div class="post-item">
              <div class="post-item-head">
                <div class="post-item-head-left">
                  <img class="profile-picture-holder" src="${postItem.profile_picture}" alt="" srcset="">
                </div>
                <div class="post-item-head-right">
                  <div class="post-user">
                    <span>${postItem.fname + " " + postItem.lname}</span>
                  </div>
                  <div class="post-details">
                    <span>${postItem.visibility}</span>
                    <span>|</span>
                    <span>${timeAgo(postItem.created_date_time)}</span>
                  </div>
                </div>
              </div>
              <a href="./post.php?postId=${postItem.post_id}" class="post-item-body">
                <span style="margin:5px;">${postItem.content}</span>
                <img style="border-radius:10px;" src=".${postItem.media}" alt="" srcset="">
              </a>
              <div class="post-item-footer">
                <div data-id=${postItem.post_id} class="like-container">
                  <img height="30px" src=${likedState}>
                  <span class="like-count">${postItem.like_count}</span>
                </div>
                <div class="comment-container">
                  <a href="./post.php?postId=${postItem.post_id}#post-comment-${postItem.post_id}">
                  <img height="30px" src="./assets/images/comment-outline.svg"></a>
                </div>
              </div>
            </div>
          `;

  // Append the post HTML to the postPlace element
  document.querySelector("#post-container").innerHTML += postHTML;
  likeHandeler();
}
  

renderPosts().catch(error => {
  console.error("Error rendering posts:", error);
});
  

