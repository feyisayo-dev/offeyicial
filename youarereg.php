<div class="name-avatar-container">
                <div class="avatar-container">
                    <img class="avatar" src="<?php echo $recipientPassport; ?>" alt="">
                </div>
                <div class="name-container">
                    <div id="name" class="name"><?php echo $recipientFirstName . ' ' . $recipientSurname; ?></div>
                    <div id="status" class="status">Calling...</div>
                </div>
            </div>
            <div class="callbody">
                <div class="row">
                    <div class="col">
                        <button id="video_call_button" class="btn btn-primary"><i class="bi bi-camera-video"></i> Video Call</button>
                    </div>
                    <div class="col">
                        <button id="audio_call_button" class="btn btn-secondary"><i class="bi bi-mic"></i> Audio Call</button>
                    </div>
                </div>
                <hr>
                <div id="local_video"></div>
                <div id="remote_video"></div>
                <div class="row">
                    <div class="btn-group" role="group" aria-label="Call buttons">
                        <button id="call_button" class="btn btn-success"><i class="bi bi-telephone"></i> Call</button>
                        <button id="hangup_button" class="btn btn-danger"><i class="bi bi-telephone-x"></i> Hang Up</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p id="call_timer">00:00:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>