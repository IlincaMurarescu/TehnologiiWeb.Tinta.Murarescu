// Initialize and add the map

// function initMap() {
//   // The location of Uluru
//   $lat = 47.159;
//   $lng = 27.587;
//   const uluru = { lat: $lat, lng: $lng };
//   // The map, centered at Uluru
//   const map = new google.maps.Map(document.getElementById("map"), {
//     zoom: 12,
//     center: uluru,
//   });
// }

// window.initMap = initMap;

// =======================google tutorial query=================js

// var map;
// var service;
// var infowindow;

// function initMap() {
//   var sydney = new google.maps.LatLng(47.159, 27.58);

//   infowindow = new google.maps.InfoWindow();

//   map = new google.maps.Map(document.getElementById("map"), {
//     center: sydney,
//     zoom: 12,
//   });

//   var request = {
//     query: "Strada Oancea",
//     fields: ["name", "geometry"],
//   };

//   var service = new google.maps.places.PlacesService(map);

//   service.findPlaceFromQuery(request, function (results, status) {
//     if (status === google.maps.places.PlacesServiceStatus.OK) {
//       for (var i = 0; i < results.length; i++) {
//         createMarker(results[i]);
//       }
//       map.setCenter(results[0].geometry.location);
//     }
//   });
// }

// =======================google tutorial places autocomplete=================js

// // Listen for the event fired when the user selects a prediction and retrieve
// // more details for that place.
// searchBox.addListener("places_changed", () => {
//   const places = searchBox.getPlaces();

//   if (places.length == 0) {
//     return;
//   }

//   // Clear out the old markers.
//   markers.forEach((marker) => {
//     marker.setMap(null);
//   });
//   markers = [];

//   // For each place, get the icon, name and location.
//   const bounds = new google.maps.LatLngBounds();

//   places.forEach((place) => {
//     if (!place.geometry || !place.geometry.location) {
//       console.log("Returned place contains no geometry");
//       return;
//     }

//     const icon = {
//       url: place.icon,
//       size: new google.maps.Size(71, 71),
//       origin: new google.maps.Point(0, 0),
//       anchor: new google.maps.Point(17, 34),
//       scaledSize: new google.maps.Size(25, 25),
//     };

//     // Create a marker for each place.
//     markers.push(
//       new google.maps.Marker({
//         map,
//         icon,
//         title: place.name,
//         position: place.geometry.location,
//       })
//     );
//     if (place.geometry.viewport) {
//       // Only geocodes have viewport.
//       bounds.union(place.geometry.viewport);
//     } else {
//       bounds.extend(place.geometry.location);
//     }
//   });
//   map.fitBounds(bounds);
// });
// =========================================improvizatiune

var $addres_latitude = 0.0;
var $addres_longitude = 0.0;

function initAutocomplete() {
  const map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 47.159, lng: 27.587 },
    zoom: 12,
    mapTypeId: "roadmap",
  });

  // Create the search box and link it to the UI element.
  const input = document.getElementById("address");
  const searchBox = new google.maps.places.SearchBox(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener("bounds_changed", () => {
    searchBox.setBounds(map.getBounds());
  });

  markers = [];

  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener("places_changed", () => {
    const places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    markers.forEach((marker) => {
      marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    const bounds = new google.maps.LatLngBounds();

    places.forEach((place) => {
      if (!place.geometry || !place.geometry.location) {
        console.log("Returned place contains no geometry");
        return;
      }

      const icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25),
      };

      // Create a marker for each place.
      markers.push(
        new google.maps.Marker({
          map,
          icon,
          title: place.name,
          position: place.geometry.location,
        })
      );
      $addres_latitude = place.geometry.location.lat();
      $addres_longitude = place.geometry.location.lng();

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
}

window.initAutocomplete = initAutocomplete;

// -------------------de scos, e sa testez fara sa consum request uri-----

// $addres_latitude = 25.789;
// $addres_longitude = 83.123;
// ---------------------------

const add = document.querySelector(".add-location-js");
var responseStatus;
add.addEventListener("click", () => {
  $address_title = document.getElementById("address-form").elements[0].value;
  console.log("numele e " + $address_title);

  let data = {
    address_name: $address_title,
    address_latitude: $addres_latitude,
    address_longitude: $addres_longitude,
  };

  fetch("http://localhost/kidpointproj/apimaps/controller/addlocation.php", {
    method: "POST",
    body: JSON.stringify(data),
    // -----------de pus inapoi
    // JSON.stringify({
    //   address_name: $address_title,
    //   address_latitue: $addres_latitude,
    //   address_longitude: $addres_longitude,
    // }),
    // -----------------
  })
    .then((res) => {
      responseStatus = res.status;
      return res.text();
    })
    .then((data) => {
      if (responseStatus != 200) alert(data);
      if (responseStatus == 200) {
        alert(data);
        location.href =
          "http://localhost/kidpointproj/client/views/MyChildren.html";
      }
    })
    .catch((err) => {
      alert(err);
    });
});

// ====================verificare==============
// const add = document.querySelector(".add-location-js");
// add.addEventListener("click", () => {
//   $address_title = document.getElementById("address-form").elements[0].value;
//   console.log("address title is: " + $address_title);
//   console.log(
//     "Aici avem lng si lat (dupa add click) " +
//       $addres_longitude +
//       $addres_latitude
//   );
// });
