<div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center z-50 bg-gray-900 bg-opacity-20">
    <div class="p-2">
        <div class="flex flex-col items-center bg-white p-4 border-2 border-gray-500 rounded-md shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16 text-red-600">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
            <h5 class="uppercase font-extrabold text-xl">Atención</h5>
            {{$slot}}
        </div>
    </div>
</div>