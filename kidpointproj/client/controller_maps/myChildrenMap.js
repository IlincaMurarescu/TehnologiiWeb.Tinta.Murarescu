// Initialize and add the map

$lat = 47.159;
$lng = 27.587;

window.markers = [];
function initMap() {
  // The location of Uluru

  const uluru = { lat: $lat, lng: $lng };
  // The map, centered at Uluru
  window.map = new google.maps.Map(document.getElementById("map"), {
    zoom: 10,
    center: uluru,
  });
  // The marker, positioned at Uluru
  // const marker = new google.maps.Marker({
  //   position: uluru,
  //   map: map,
  // });
}

window.initMap = initMap;

function findMe(child) {
  $child_id = child.getAttribute("data-child");
  console.log($child_id);

  // $child_id = 4;

  let data = {
    child_id: $child_id,
  };

  fetch(
    "http://localhost/kidpointproj/api_entities/controller/get-child-location.php",
    {
      method: "POST",
      body: JSON.stringify(data),
    }
  )
    .then((res) => {
      responseStatus = res.status;
      return res.text();
    })
    .then((data) => {
      if (responseStatus != 200) alert(data);
      if (responseStatus == 200) {
        var info = JSON.parse(data);
        console.log(info);
        $current_latitude = info.latitude;
        $current_longitude = info.longitude;
        $refpoint_latitude = info.point_latitude;
        $refpoint_longitude = info.point_longitude;
        $distance = info.distance;
        if ($distance > 1000) {
          $distance = $distance / 1000;
          $distance = $distance.toFixed(2);
          $point_title =
            "Current reference point. The distance is: " + $distance + " km.";
        } else {
          $distance = $distance.toFixed(2);

          $point_title =
            "Current reference point. The distance is: " + $distance + " m.";
        }

        if (window.markers[1] != null) {
          window.markers[1].setMap(null);
          window.markers.pop();
        }
        if (window.markers[0] != null) {
          window.markers[0].setMap(null);
          window.markers.pop();
        }
        var marker = new google.maps.Marker({
          map: window.map,
          title: "Your child is here",
          position: new google.maps.LatLng(
            $current_latitude,
            $current_longitude
          ),
        });
        window.markers.push(marker);

        if ($refpoint_latitude != 0 || $refpoint_latitude != null) {
          var marker2 = new google.maps.Marker({
            map: window.map,
            position: new google.maps.LatLng(
              $refpoint_latitude,
              $refpoint_longitude
            ),
            title: $point_title,
            icon: {
              url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
            },
          });
          window.markers.push(marker2);
        }
      }
    })
    .catch((err) => {
      alert(err);
    });
}

// --

// ----------------------fix ca la andrada V

// // Initialize and add the map

// $lat = 47.159;
// $lng = 27.587;
// function initMap() {
//   // The location of Uluru

//   const uluru = { lat: $lat, lng: $lng };
//   // The map, centered at Uluru
//   window.map = new google.maps.Map(document.getElementById("map"), {
//     zoom: 12,
//     center: uluru,
//   });
//   // The marker, positioned at Uluru
//   // const marker = new google.maps.Marker({
//   //   position: uluru,
//   //   map: map,
//   // });
// }

// window.initMap = initMap;

// function findMe(child) {
//   console.log(child.getAttribute("data-child"));
//   $child_id = child.getAttribute("data-child");
//   // $child_id = 4;

//   let data = {
//     child_id: $child_id,
//   };

//   fetch(
//     "http://localhost/kidpointproj/api_entities/controller/get-child-location.php",
//     {
//       method: "POST",
//       body: JSON.stringify(data),
//     }
//   )
//     .then((res) => {
//       // ----ce aveam inainte
//       // responseStatus = res.status;
//       // return res.text();
//       // ----ce aveam inainte

//       if (!res.ok) {
//         throw Error("Error");
//       }
//       return res.json();
//     })
//     .then((data) => {
//       // ----ce aveam inainte

//       // if (responseStatus != 200) alert(data);
//       // if (responseStatus == 200) {
//       //  $info=json_decode(data);
//       //  $current_latitude=$info['latitude'];
//       //  $current_longitude=$info['longitude'];
//       // (update) => {
//       // ----ce aveam inainte

//       data.map((position) => {
//         $mylatitude = position.latitude;
//         $mylongitude = position.longitude;
//       });

//       // window.index = 10;
//       console.log("latitudinea este " + $mylatitude);
//       new google.maps.Marker({
//         map: window.map,
//         position: new google.maps.LatLng($mylatitude, $mylongitude),
//         icon: {
//           scaledSize: new google.maps.Size(50, 50), // scaled size
//           origin: new google.maps.Point(0, 0), // origin
//           anchor: new google.maps.Point(0, 0),
//           url: "https://media-exp1.licdn.com/dms/image/C5603AQGeC6MtiWJWTA/profile-displayphoto-shrink_200_200/0/1648324392913?e=1655942400&v=beta&t=bUZqivXzHHDynY2oYF4TTG-VQ8jcAr_oPkAkSoaUDQk",
//         },
//       });

//       // ----ce aveam inainte

//       // };

//       // }
//       // ----ce aveam inainte
//     })
//     .catch((err) => {
//       alert(err);
//     });
// }

// AIzaSyAON0S - VxHGI4z9gf3Q - HKuM1yzJzgAIrg;
