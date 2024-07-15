<div class='rate modal change' id='rate-modal'>
    <button class='btn-small green modal-close'><i class='fas fa-times'></i></button>
    <input type="hidden" id='rate-id' value=''>
    <input type="hidden" id='rate-type' value=''>
    <h5>Leave a comment</h5>
    <div class='input-field'>
        <textarea class='materialize-textarea' placeholder="Comment..." id='rate-comment' maxlength="100"></textarea>
    </div>
    <div>
        <button onclick="submitRating(1)" class='btn-small green'><span>1</span><i class='material-icons yellow-text'>star</i></button>
        <button onclick="submitRating(2)" class='btn-small green'><span>2</span><i class='material-icons yellow-text'>star</i></button>
        <button onclick="submitRating(3)" class='btn-small green'><span>3</span><i class='material-icons yellow-text'>star</i></button>
        <button onclick="submitRating(4)" class='btn-small green'><span>4</span><i class='material-icons yellow-text'>star</i></button>
        <button onclick="submitRating(5)" class='btn-small green'><span>5</span><i class='material-icons yellow-text'>star</i></button>
    </div>
</div>