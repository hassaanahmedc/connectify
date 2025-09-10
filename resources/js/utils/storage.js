export class CACHE {
    constructor(limit = 100) {
        this.limit = limit;
         this.cache = new Map();
    }

    get(key){
        if(!this.cache.has(key)) return undefined;
        const value = this.cache.get(key)
        this.cache.delete(key);
        this.cache.set(key, value);
        return value;   
    }

    store(key, value){
        if(this.cache.has(key)) {
            this.cache.delete(key);
        } else if(this.cache.size >= this.limit) {
            const oldestKey = this.cache.keys().next().value;
            this.cache.delete(oldestKey);
        }
        this.cache.set(key, value);
    }
}