<li>
    <a class="flex gap-4 px-4 py-2 text-gray-500 hover:bg-lightMode-background" href="${escapeHtml(data.url ?? "#")}">
        <figure>
            <img class="h-auto w-9 rounded-full bg-gray-200 object-cover"
                src="${data.avatar ?? "https://placewaifu.com/image/200"}">
        </figure>
        <div>
            <div class="text-base font-medium">${escapeHtml(data.title ?? data.snipped ?? "")}</div>
            <div class="text-xs text-gray-500">${escapeHtml(data.type ?? "")}</div>
        </div>
    </a>
</li>
