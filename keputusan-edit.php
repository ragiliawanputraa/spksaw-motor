<?php
require "include/conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data alternatif dan nilai
    $sql = "SELECT a.name, e.id_criteria, e.value, c.criteria
            FROM saw_evaluations e
            JOIN saw_alternatives a ON e.id_alternative = a.id_alternative
            JOIN saw_criterias c ON e.id_criteria = c.id_criteria
            WHERE e.id_alternative = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Simpan hasil ke array
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[$row['id_criteria']] = $row;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Simpan perubahan
        foreach ($data as $criteria_id => $value) {
            $new_value = $_POST['value'][$criteria_id];

            $sql_update = "UPDATE saw_evaluations SET value = ? WHERE id_alternative = ? AND id_criteria = ?";
            $stmt_update = $db->prepare($sql_update);
            $stmt_update->bind_param("dii", $new_value, $id, $criteria_id);
            $stmt_update->execute();
        }

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Nilai</title>
    <?php require "layout/head.php"; ?>
</head>
<body>
    <div id="app">
        <div id="main">
            <div class="page-heading">
                <h3>Edit Nilai Alternatif: <?php echo htmlspecialchars($data[1]['name']); ?></h3>
            </div>
            <div class="page-content">
                <form action="" method="POST">
                    <?php foreach ($data as $criteria_id => $info): ?>
                        <div class="form-group">
                            <label for="value[<?php echo $criteria_id; ?>]"><?php echo htmlspecialchars($info['criteria']); ?>:</label>
                            <input type="text" name="value[<?php echo $criteria_id; ?>]" value="<?php echo htmlspecialchars($info['value']); ?>" class="form-control" required>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
