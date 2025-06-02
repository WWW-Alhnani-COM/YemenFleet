<x-app-layout>
    <x-slot name="header">لوحة التحكم الرئيسية</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- بطاقة إحصائية -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 dark:text-gray-400">المركبات</p>
                    <h3 class="text-3xl font-bold">42</h3>
                </div>
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                    <i class="fas fa-ship text-xl"></i>
                </div>
            </div>
        </div>

        <!-- بطاقة أخرى -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 dark:text-gray-400">الصيانة</p>
                    <h3 class="text-3xl font-bold">5</h3>
                </div>
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300">
                    <i class="fas fa-wrench text-xl"></i>
                </div>
            </div>
        </div>

        <!-- بطاقة ثالثة -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 dark:text-gray-400">العملاء</p>
                    <h3 class="text-3xl font-bold">18</h3>
                </div>
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول حديث -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold">أحدث المركبات</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">النوع</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">آخر صيانة</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">#FL-1001</td>
                        <td class="px-6 py-4 whitespace-nowrap">شاحنة ثقيلة</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-sm rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">نشطة</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">2023-06-15</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">#FL-1002</td>
                        <td class="px-6 py-4 whitespace-nowrap">سفينة صيد</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-sm rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">تحت الصيانة</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">2023-06-10</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>