/**
 * post.js
 * Comment thread interactions for the post detail page:
 * reply forms, reply thread collapse, comment body collapse.
 * Dark mode is handled by darkmode.js (loaded separately).
 */

function toggleReplyForm(commentId) {
    document.getElementById('reply-form-' + commentId).classList.toggle('d-none');
}

function toggleReplies(commentId) {
    const section   = document.getElementById('replies-section-' + commentId);
    const btn       = document.getElementById('replies-btn-' + commentId);
    const isHidden  = section.classList.contains('d-none');
    const count     = section.querySelectorAll('.comment-thread').length;

    section.classList.toggle('d-none');
    btn.innerHTML = isHidden
        ? `<i class="bi bi-chevron-up"></i> <span id="replies-toggle-${commentId}">Hide replies</span>`
        : `<i class="bi bi-chevron-down"></i> <span id="replies-toggle-${commentId}">Show ${count} replies</span>`;
}

function toggleCommentDetails(commentId) {
    const details  = document.getElementById('comment-details-' + commentId);
    const btn      = document.getElementById('hide-btn-' + commentId);
    const isHidden = details.classList.contains('d-none');

    details.classList.toggle('d-none');
    btn.innerHTML = isHidden ? '<i class="bi bi-chevron-up"></i>'   : '<i class="bi bi-chevron-down"></i>';
    btn.title     = isHidden ? 'Hide comment' : 'Show comment';
}