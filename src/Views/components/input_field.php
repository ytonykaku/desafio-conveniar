<div class="mb-4">
    <label for="<?= htmlspecialchars($name) ?>" class="block text-gray-700 font-semibold mb-2">
        <?= htmlspecialchars($label) ?>
    </label>
    <input
        type="<?= htmlspecialchars($type) ?>"
        id="<?= htmlspecialchars($name) ?>"
        name="<?= htmlspecialchars($name) ?>"
        value="<?= htmlspecialchars($value ?? '') ?>"
        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        <?= $required ? 'required' : '' ?>
    >
</div>
