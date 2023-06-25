let localStream;
let remoteStream;
let peerConnection;

// my stream
let init = async () => {
    localStream = await navigator.mediaDevices.getUserMedia({
        video: true,
        audio: true
    });
    document.getElementById(UserId).srcObject = localStream;
    createOffer();
}

// other user's stream
let createOffer = async () => {
    peerConnection = new RTCPeerConnection();

    remoteStream = new MediaStream();
    document.getElementById(userB).srcObject = remoteStream;

    // passing local stream
    localStream.getTracks().forEach((track) => {
        peerConnection.addTrack(track, localStream);
    });

    // when peer has its tracks
    peerConnection.ontrack = (event) => {
        event.streams[0].getTracks().forEach((track) => {
            remoteStream.addTrack(track);
        });
    };

    // generate ICE candidates
    peerConnection.onicecandidate = (event) => {
        if (event.candidate) {
            console.log('New ICE candidate:', event.candidate);
        }
    };

    // Creating offer
    let offer = await peerConnection.createOffer();
    await peerConnection.setLocalDescription(offer);

    // Log the offer
    console.log('Offer:', offer);

    // Listen for ICE candidates
    peerConnection.onicecandidate = (event) => {
        if (event.candidate) {
            console.log('New ICE candidate:', event.candidate);
        } else {
            console.log('ICE candidate gathering complete.');
        }
    };
}

// Call the init function to start the process
init();

