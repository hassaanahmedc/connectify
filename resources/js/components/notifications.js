export default () => ({
    searchOpen: false,                                         
    leftSidebarOpen: false,                                    
    rightSidebarOpen: false,
    notifications: [],
    open: false,
    error: '',
    isLoading: false,
    hasBeenFetched: false,

    async init() {
        try {
        const response = await fetch('/notifications');
        if (!response.ok) return;

        const data = await response.json();
        this.notifications = data.notifications;
        this.hasBeenFetched = true;

        } catch (error) {
            this.error = 'Error fetching notifications.' ;

        } finally {
            this.isLoading = false;
        }
    },

    async fetchNotifications() {
        if (this.hasBeenFetched) return;
        this.isLoading = true;

        try {
            const response = await fetch('/notifications');
            if (!response.ok) this.error = 'HTTP error! status: ${response.status}';

            const data = await response.json();
            this.notifications = data.notifications;
            this.hasBeenFetched = true;

            } catch (error) {
                this.error = 'Error fetching notifications.' ;

            } finally {
                this.isLoading = false;
            }
    }, 
    
    async markAllAsRead() {
        try {
            const response = await fetch('/notifications/mark-all-read');
            if (!response.ok) this.error = 'Failed to mark notifications as read';

            this.notifications = this.notifications.map(notification => ({
                ...notification,
                read_at: new Date().toISOString()
            }));
            
        } catch (error) {
            this.error = 'Could not mark notifications as read';
        }

    },

    get unreadCount() {
        return this.notifications.filter(n => !n.read_at).length;
    }
})