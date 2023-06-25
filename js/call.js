var localStream;
var remoteStream;
let peerConnection

// my stream
let init = async () => {
    localStream = await navigator.mediaDevices.getUserMedia({
        video: true,
        audio: true
    })
    document.getElementById(UserId).srcObject = localStream
}

// other user's sream
let createOffer = async () => {
    peerConnection = new RTCPeerConnection();

    remoteStream = new MediaStream();
    document.getElementById('userB').srcObject = remoteStream;

    // Creating offer
    let offer = await peerConnection.createOffer();
    await peerConnection.setLocalDescription(offer);

    // Log the offer
    console.log('Offer:', offer);
}

// Call the createOffer function to initiate the offer creation
createOffer();


init()