/**
 * community.js
 * Like toggling and post sharing for the Community Hub feed.
 * Dark mode is handled by darkmode.js (loaded separately).
 */

function toggleLike(button, postId) {
    const likeCountSpan = button.querySelector('.like-count');
    const icon          = button.querySelector('i');

    // Optimistic toggle
    button.classList.toggle('active');

    const formData = new FormData();
    formData.append('action', 'toggle_like');
    formData.append('post_id', postId);

    fetch('../../app/controllers/likesController.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                button.classList.toggle('active', data.isLiked);
                icon.classList.toggle('bi-heart',      !data.isLiked);
                icon.classList.toggle('bi-heart-fill',  data.isLiked);
                likeCountSpan.textContent = data.likeCount;
            } else {
                // Revert optimistic toggle on failure
                button.classList.toggle('active');
            }
        })
        .catch(() => button.classList.toggle('active'));
}

function sharePost(postId) {
    const url = window.location.origin
        + window.location.pathname.replace(/community$/, 'post')
        + '?id=' + postId;

    if (navigator.share) {
        navigator.share({ title: 'Check this out on USTP E-Gallery', url })
            .catch(err => console.log('Share cancelled:', err));
    } else {
        navigator.clipboard.writeText(url)
            .then(() => alert('Post link copied to clipboard!'));
    }
}