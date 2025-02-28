export function timeAgo(date) {
    const now = new Date();
    const justNow = Math.floor((now - new Date(date)) / 1000);

    if (justNow < 60) return `Just Now`;
    const minutesAgo = Math.floor(justNow / 60);
    if (minutesAgo < 60) return `${minutesAgo} minutes ago`;
    const hoursAgo = Math.floor(minutesAgo / 60);
    if (hoursAgo < 24) return `${hoursAgo} hours ago`;
    const daysAgo = Math.floor(hoursAgo / 24);
    if (daysAgo < 7) return `${daysAgo} days ago`;
    const weeksAgo = Math.floor(daysAgo / 7);
    if (weeksAgo < 4) return `${weeksAgo} weeks ago`;
    const monthsAgo = Math.floor(daysAgo / 30);
    if (monthsAgo < 12) return `${monthsAgo} months ago`;
    const yearsAgo = Math.floor(daysAgo / 365);
    return `${yearsAgo} years ago`;
}