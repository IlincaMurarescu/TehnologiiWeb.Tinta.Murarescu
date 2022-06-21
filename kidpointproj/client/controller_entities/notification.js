$(document).ready(function () {
  showNotification();
  setInterval(function () {
    showNotification();
  }, 20000);
});
function showNotification() {
  if (!Notification) {
    console.log(error);
    return;
  }
  // console.log(Notification.permission);
  if (Notification.permission !== "granted") {
    Notification.requestPermission();
  } else {
    $.ajax({
      url: "../../api_entities/controller/getNotification.php",
      success: function (data, textStatus, jqXHR) {
        var data = jQuery.parseJSON(JSON.stringify(data));
        console.log(data);
        console.log(data[0]["notif_title"]);

        var notifikasi = new Notification(data[0]["notif_title"], {
          body: data[0]["notif_msg"],
        });
        notifikasi.onclick = function () {
          window.open(
            "http://localhost/kidpointproj/client/views/MyChildren.html"
          );
          notifikasi.close();
        };
        let html = "";
        data.map((notif) => {
          html += `<div class="notification">
    <ion-icon
      class="notification-icon"
      name="alert-circle-outline"
    ></ion-icon>
    <p class="notification-text">
      ${notif.first_name} ${notif.last_name} has fallen! Please check for injuries!
    </p>
  </div>`;
        });

        // console.log(html);
        document.querySelector(".notifications-card").innerHTML = html;
        setTimeout(function () {
          notifikasi.close();
        }, 5000);
      },
      error: function (jqXHR, textStatus, errorThrown) {},
    });
  }
}

// function displayNotifications() {
//   let html = "";
//   data.map((notif) => {
//     html += `<div class="notification">
//     <ion-icon
//       class="notification-icon"
//       name="alert-circle-outline"
//     ></ion-icon>
//     <p class="notification-text">
//       ${notif.first_name} ${notif.last_name} has fallen! Please check for injuries!
//     </p>
//   </div>`;
//   });

//   // console.log(html);
//   document.querySelector(".notifications-card").innerHTML = html;
// }
