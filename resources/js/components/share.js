// This file holds the logic to copy the post url for sharing.

export default (url) => ({
    copied: false,
    shareUrl: url,
    
    copyToClipboard() {
        navigator.clipboard.writeText(this.shareUrl);
        this.copied = true;

        setTimeout(() => {
            this.copied = false;   
        }, 900);
    }
});