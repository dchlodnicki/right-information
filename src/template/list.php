<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of persons</title>
    
    <link rel="stylesheet" type="text/css" href="/src/template/css/style.css?<?php echo time(); ?>" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>
    <form id="filtration" action="/src/Model/set_filtration.php" method="post">
        <div class="box">
            <label for="sort-by">
                <span>Sort by</span>
                <select name="sort_by" id="sort-by">
                    <option <?php if(isset($_GET['sort_by']) && $_GET['sort_by'] == 2) {
                        echo 'selected';
                    } ?> value="2">Name</option>
                    <option <?php if(isset($_GET['sort_by']) && $_GET['sort_by'] == 3) {
                        echo 'selected';
                    } ?> value="3">Address</option>
                    <option <?php if(isset($_GET['sort_by']) && $_GET['sort_by'] == 4) {
                        echo 'selected';
                    } ?> value="4">Birth date</option>
                    <option <?php if(isset($_GET['sort_by']) && $_GET['sort_by'] == 5) {
                        echo 'selected';
                    } ?> value="5">Color</option>
                    <option <?php if(isset($_GET['sort_by']) && $_GET['sort_by'] == 6) {
                        echo 'selected';
                    } ?> value="6">Website</option>
                </select>
            </label>
        </div>
        <div class="box">
            <label for="born_from">
                <span>Born from</span>
                <input <?php if(isset($_GET['born_from'])) {
                    echo 'value="' . $_GET['born_from'] . '"';
                } else {
                    echo 'value="1900"'; }?> name="born_from" type="number" min="1900" max="<?php echo date('Y'); ?>" id="born_from">
            </label>
            <label for="born_to">
                <span>to</span>
                <input <?php if(isset($_GET['born_to'])) {
                    echo 'value="' . $_GET['born_to'] . '"';
                } else {
                    echo 'value="' . date('Y') . '"';} ?> name="born_to" type="number" min="1900" max="<?php echo date('Y'); ?>" id="born_to">
            </label>
        </div>
        <div class="box">
            <label for="with-color">
                <input <?php if(isset($_GET['with_color']) && $_GET['with_color'] === 'on') {
                    echo 'checked';
                } ?> type="checkbox" name="with_color" id="with-color">
                <span>Only with color</span>
                <div class="check-mark">
                    <i class="fas fa-check"></i>
                </div>
            </label>

        </div>
        <div class="box">
            <label for="with-website">
                <input <?php if(isset($_GET['with_website']) && $_GET['with_website'] === 'on') {
                    echo 'checked';
                } ?> type="checkbox" name="with_website" id="with-website">
                <span>Only with color</span>
                <div class="check-mark">
                    <i class="fas fa-check"></i>
                </div>
            </label>

        </div>
        <input type="submit" value="Set">
    </form>
    <table>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Birth date</th>
            <th>Color</th>
            <th>Website</th>
            <th>Action</th>
        </tr>
        <?php
            
        foreach($this->data as $person){

            echo '<tr>
                    <td>'.$person->name.'</td>
                    <td>'.$person->address.'</td>
                    <td>'.$person->birth_date.'</td>
                    <td style="background:'.$person->color.'">'.$person->color.'</td>
                    <td>'.$person->website.'</td>
                    <td>
                        <a href="/src/Model/delete_person.php?id='.$person->id.'">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>';
        }
            
        ?>
    </table>
    <form id="add" action="/src/Model/add_person.php" method="post">
        <input name="name" type="text" placeholder="Name" required>
        <input name="address" type="text" placeholder="Address" required>
        <input name="date" type="date" value="<?php echo date('Y-m-d'); ?>" required>
        <input name="time" type="time" value="<?php echo date('H:i'); ?>" required>
        <input name="color" type="color" value="#ffffff">
        <input name="website" type="text" placeholder="Website">
        <input type="submit" value="Add new person">
    </form>
    <div id="pagination">
        <?php
        
        for($i = 1; $i <= $this->num_page; $i++) {
            
            echo '<a href="/index.php?'.$this->http_data.'&number_page='.$i.'">'.$i.'</a>';
        }
        
        ?>
    </div>
</body>
</html>