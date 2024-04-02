# Diff Details

Date : 2024-04-02 14:35:39

Directory /opt/lampp/htdocs/MitraPark

Total : 80 files,  6618 codes, 137 comments, 1214 blanks, all 7969 lines

[Summary](results.md) / [Details](details.md) / [Diff Summary](diff.md) / Diff Details

## Files
| filename | language | code | comment | blank | total |
| :--- | :--- | ---: | ---: | ---: | ---: |
| [.idea/MitraPark.iml](/.idea/MitraPark.iml) | XML | 12 | 0 | 0 | 12 |
| [.idea/modules.xml](/.idea/modules.xml) | XML | 8 | 0 | 0 | 8 |
| [.idea/vcs.xml](/.idea/vcs.xml) | XML | 6 | 0 | 0 | 6 |
| [.idea/workspace.xml](/.idea/workspace.xml) | XML | 71 | 0 | 0 | 71 |
| [admin/index.php](/admin/index.php) | PHP | 101 | 0 | 24 | 125 |
| [admin/logout.php](/admin/logout.php) | PHP | 4 | 0 | 1 | 5 |
| [admin/parts/navbar.php](/admin/parts/navbar.php) | PHP | 13 | 0 | 2 | 15 |
| [admin/parts/sidebar.php](/admin/parts/sidebar.php) | PHP | 40 | 0 | 1 | 41 |
| [admin/script.js](/admin/script.js) | JavaScript | 49 | 1 | 20 | 70 |
| [admin/style.css](/admin/style.css) | CSS | 428 | 7 | 4 | 439 |
| [admin/style1.css](/admin/style1.css) | CSS | 523 | 8 | 61 | 592 |
| [admin/test.php](/admin/test.php) | PHP | 176 | 0 | 22 | 198 |
| [admin/users.php](/admin/users.php) | PHP | 162 | 0 | 37 | 199 |
| [changePassword.php](/changePassword.php) | PHP | 125 | 0 | 21 | 146 |
| [chat.php](/chat.php) | PHP | 229 | 5 | 42 | 276 |
| [feed.php](/feed.php) | PHP | 160 | 0 | 46 | 206 |
| [getUpdate.php](/getUpdate.php) | PHP | 3 | 0 | 2 | 5 |
| [index.php](/index.php) | PHP | 3 | 0 | 1 | 4 |
| [kurakani.php](/kurakani.php) | PHP | 98 | 0 | 11 | 109 |
| [login.php](/login.php) | PHP | 114 | 2 | 25 | 141 |
| [logout.php](/logout.php) | PHP | 9 | 0 | 1 | 10 |
| [mitras.php](/mitras.php) | PHP | 163 | 0 | 24 | 187 |
| [notifications.php](/notifications.php) | PHP | 127 | 5 | 19 | 151 |
| [parts/entryCheck.php](/parts/entryCheck.php) | PHP | 13 | 0 | 1 | 14 |
| [parts/feed-midbody.php](/parts/feed-midbody.php) | PHP | 49 | 0 | 4 | 53 |
| [parts/js-script-files/js-script.php](/parts/js-script-files/js-script.php) | PHP | 82 | 3 | 21 | 106 |
| [parts/kurakani/leftNavPart.php](/parts/kurakani/leftNavPart.php) | PHP | 16 | 0 | 2 | 18 |
| [parts/leftSidebar.php](/parts/leftSidebar.php) | PHP | 48 | 0 | 9 | 57 |
| [parts/navbar-template.html](/parts/navbar-template.html) | HTML | 112 | 4 | 16 | 132 |
| [parts/navbar.php](/parts/navbar.php) | PHP | 52 | 0 | 3 | 55 |
| [parts/rightSidebar.php](/parts/rightSidebar.php) | PHP | 26 | 0 | 1 | 27 |
| [post.php](/post.php) | PHP | 859 | 8 | 137 | 1,004 |
| [postComments.php](/postComments.php) | PHP | 102 | 0 | 28 | 130 |
| [postLikes.php](/postLikes.php) | PHP | 81 | 0 | 18 | 99 |
| [posts.js](/posts.js) | JavaScript | 150 | 2 | 35 | 187 |
| [profile.php](/profile.php) | PHP | 327 | 5 | 52 | 384 |
| [server/api/addLike.php](/server/api/addLike.php) | PHP | 24 | 0 | 4 | 28 |
| [server/api/comments/deleteComment.php](/server/api/comments/deleteComment.php) | PHP | 24 | 0 | 12 | 36 |
| [server/api/comments/deleteReplyComment.php](/server/api/comments/deleteReplyComment.php) | PHP | 33 | 0 | 8 | 41 |
| [server/api/comments/getReplyComments.php](/server/api/comments/getReplyComments.php) | PHP | 17 | 0 | 6 | 23 |
| [server/api/comments/insertReplyComment.php](/server/api/comments/insertReplyComment.php) | PHP | 32 | 0 | 10 | 42 |
| [server/api/comments/updateComment.php](/server/api/comments/updateComment.php) | PHP | 25 | 0 | 12 | 37 |
| [server/api/comments/updateReplyComment.php](/server/api/comments/updateReplyComment.php) | PHP | 35 | 0 | 11 | 46 |
| [server/api/getComments.php](/server/api/getComments.php) | PHP | 17 | 0 | 6 | 23 |
| [server/api/getFriendRequests.php](/server/api/getFriendRequests.php) | PHP | 30 | 2 | 11 | 43 |
| [server/api/getLikes.php](/server/api/getLikes.php) | PHP | 17 | 0 | 6 | 23 |
| [server/api/getUsers.php](/server/api/getUsers.php) | PHP | 14 | 5 | 5 | 24 |
| [server/api/handleRequest.php](/server/api/handleRequest.php) | PHP | 59 | 38 | 17 | 114 |
| [server/api/insertComment.php](/server/api/insertComment.php) | PHP | 20 | 0 | 6 | 26 |
| [server/api/kurakani/deleteKurakani.php](/server/api/kurakani/deleteKurakani.php) | PHP | 17 | 2 | 6 | 25 |
| [server/api/kurakani/getKurakaniUsers.php](/server/api/kurakani/getKurakaniUsers.php) | PHP | 29 | 0 | 10 | 39 |
| [server/api/kurakani/getMessage.php](/server/api/kurakani/getMessage.php) | PHP | 13 | 0 | 13 | 26 |
| [server/api/kurakani/sendMessage.php](/server/api/kurakani/sendMessage.php) | PHP | 20 | 0 | 12 | 32 |
| [server/api/notification/getNewNotificationCount.php](/server/api/notification/getNewNotificationCount.php) | PHP | 12 | 0 | 0 | 12 |
| [server/api/notifications/getNotifications.php](/server/api/notifications/getNotifications.php) | PHP | 2 | 0 | 3 | 5 |
| [server/api/posts/get-my-posts.php](/server/api/posts/get-my-posts.php) | PHP | 36 | 5 | 10 | 51 |
| [server/api/posts/get-posts.php](/server/api/posts/get-posts.php) | PHP | 39 | 5 | 8 | 52 |
| [server/api/posts/report-post.php](/server/api/posts/report-post.php) | PHP | 23 | 0 | 5 | 28 |
| [server/api/strict-mode/check_strict_mode.php](/server/api/strict-mode/check_strict_mode.php) | PHP | 21 | 0 | 10 | 31 |
| [server/api/strict-mode/redirect_strict_mode.php](/server/api/strict-mode/redirect_strict_mode.php) | PHP | 14 | 0 | 6 | 20 |
| [server/api/strict-mode/update_strictMode.php](/server/api/strict-mode/update_strictMode.php) | PHP | 27 | 0 | 11 | 38 |
| [server/api/strict-mode/update_warning.php](/server/api/strict-mode/update_warning.php) | PHP | 16 | 0 | 9 | 25 |
| [server/api/updatePost.php](/server/api/updatePost.php) | PHP | 51 | 0 | 15 | 66 |
| [server/api/updateProfile.php](/server/api/updateProfile.php) | PHP | 25 | 0 | 6 | 31 |
| [server/api/update_activity_dateTime.php](/server/api/update_activity_dateTime.php) | PHP | 10 | 0 | 4 | 14 |
| [server/api/uploadPost.php](/server/api/uploadPost.php) | PHP | 43 | 0 | 14 | 57 |
| [server/db_connection.php](/server/db_connection.php) | PHP | 6 | 2 | 4 | 12 |
| [server/deletePost.php](/server/deletePost.php) | PHP | 25 | 0 | 5 | 30 |
| [server/functions.php](/server/functions.php) | PHP | 113 | 16 | 32 | 161 |
| [server/getAllMitras.php](/server/getAllMitras.php) | PHP | 2 | 0 | 3 | 5 |
| [server/validation.php](/server/validation.php) | PHP | 99 | 0 | 15 | 114 |
| [setting.php](/setting.php) | PHP | 65 | 0 | 10 | 75 |
| [signup.php](/signup.php) | PHP | 216 | 2 | 27 | 245 |
| [strict-mode-timeout.php](/strict-mode-timeout.php) | PHP | 66 | 0 | 11 | 77 |
| [strict-mode.php](/strict-mode.php) | PHP | 172 | 3 | 33 | 208 |
| [style.css](/style.css) | CSS | 246 | 1 | 54 | 301 |
| [timeOutWarn.php](/timeOutWarn.php) | PHP | 52 | 0 | 11 | 63 |
| [uploadProfile.php](/uploadProfile.php) | PHP | 31 | 0 | 10 | 41 |
| [user.php](/user.php) | PHP | 236 | 6 | 52 | 294 |
| [user_uploads/index.php](/user_uploads/index.php) | PHP | 3 | 0 | 0 | 3 |

[Summary](results.md) / [Details](details.md) / [Diff Summary](diff.md) / Diff Details