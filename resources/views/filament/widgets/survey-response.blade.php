<table class="table-auto w-full border-collapse border border-blue-200">
    <thead>
        <tr class="bg-blue-100">
            <th class="border border-blue-300 px-4 py-2">Question</th>
            <th class="border border-blue-300 px-4 py-2">Answer</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($this->getTableData() as $row)
            <tr>
                <td class="border border-blue-300 px-4 py-2">{{ $row['question'] }}</td>
                <td class="border border-blue-300 px-4 py-2">{{ $row['answer'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="border border-blue-300 px-4 py-2 text-center">
                    No answers available.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
