<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<style>
.footer {
    background-color: #fbffe9;
    display: flex;
    flex-direction: column;
    width: 100%;
    padding: 20px 5%;
    box-sizing: border-box; 
}

.footer-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px; 
}

.footer-column {
    flex: 1 1 calc(25% - 20px); 
    min-width: 200px; 
    max-width: 300px; 
    box-sizing: border-box;
}

.footer-heading {
    color: #45b4b1;
    font-size: 18px;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
}

.footer-links {
    display: flex;
    flex-direction: column;
    gap: 8px; 
    font-size: 14px;
    color: #737373;
    letter-spacing: 0.4px;
}

.footer-link {
    font-style: italic;
    text-decoration: none; 
    color: inherit; 
    transition: color 0.2s ease; 
}

.footer-link:hover {
    color: #45b4b1; 
}

.footer-form {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 400px;
    gap: 10px; 
}

.footer-input {
    border: 1px solid #45b4b1;
    background-color: #fff;
    width: 100%; 
    padding: 10px;
    font-size: 14px;
    color: #737373;
    border-radius: 4px;
    box-sizing: border-box;
}

.footer-button {
    background-color: #45b4b1;
    border: none;
    color: #fff;
    padding: 10px 15px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 4px;
    align-self: flex-start; 
    transition: background-color 0.2s ease; 
}

.footer-button:hover {
    background-color: #3a9998;
}

.footer-bottom {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    font-size: 12px;
    color: #737373;
    gap: 10px; 
}

.footer-links-bottom {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px; 
}

.footer-link-bottom {
    font-style: italic;
    text-decoration: none;
    color: inherit;
    transition: color 0.2s ease;
}

.footer-link-bottom:hover {
    color: #45b4b1;
}
</style>

<footer class="footer">
        </div>
        <p class="footer-copyright">© 2024 All Rights Reserved</p>
    </div>
</footer>
</html>