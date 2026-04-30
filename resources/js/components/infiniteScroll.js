import { fetchData } from "../utils/api";

export default (initialUrl) => ({
    nextPageUrl: initialUrl,
    hasMore: true,
    isLoading: false,
    observer: null,

    init() {
        if(!this.nextPageUrl) {
            this.hasMore = false;
            return;
        };
        const scrollContainer = document.querySelector('main');

        this.observer = new IntersectionObserver((entries) => {
            if(entries[0].isIntersecting && !this.isLoading && this.hasMore) {
                this.loadMore();
            };
        }, { 
            rootMargin: '0px 0px 800px 0px', 
            root: scrollContainer, 
            threshold: 0 
        });

        this.$nextTick(() => {
            if (this.$refs.sentinal) {
                this.observer.observe(this.$refs.sentinal);
            }
        });
    },

    async loadMore() {
        this.isLoading = true;
        const sentinelEl = this.$refs.sentinal;

        if (this.observer && sentinelEl) {
            this.observer.unobserve(sentinelEl);
        }

        try {
            const response = await fetchData(this.nextPageUrl);
    
            if (response.success && response.markup) {
                this.$refs.sentinal.insertAdjacentHTML('beforebegin', response.markup);
                this.nextPageUrl = response.nextPageUrl;
                this.hasMore = !!this.nextPageUrl;
            }


        } catch (error) {
            console.error("Error fetching Posts.");
        } finally {
            this.isLoading = false;

            this.$nextTick(() => {
                if (this.hasMore && this.observer && sentinelEl) {
                    this.observer.observe(sentinelEl);
                }
            })
        }
    },
})