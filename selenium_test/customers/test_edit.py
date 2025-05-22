from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
import time

chrome_driver_path = r"C:\Users\nakabayashi-yugo\tools\chromedriver-win64\chromedriver.exe"

def test_edit(data):
    service = Service(executable_path=chrome_driver_path)
    driver = webdriver.Chrome(service=service)
    login(driver)

    try:
        driver.get("http://localhost:3000/cust_edit/93")
        WebDriverWait(driver, 10).until(
            EC.text_to_be_present_in_element_value((By.NAME, "cust-name"), "加藤大輔")
        )

        fill_user_form(driver, data)
        driver.find_element(By.XPATH, "//button[text()='編集']").click()

        # ✅ アラートが出るまで最大10秒待つ
        WebDriverWait(driver, 10).until(EC.alert_is_present())

        time.sleep(1)
        # ✅ アラート処理
        try:
            alert = driver.switch_to.alert
            print("アラート内容:", alert.text)
            alert.accept()
        except:
            print("⚠️ アラートが見つかりませんでした")

        time.sleep(1)

        # 成功後の画面の文言確認（必要に応じて変更）
        assert "顧客情報編集" in driver.page_source

    finally:
        driver.quit()

def fill_user_form(driver, data):
    e = driver.find_element(By.NAME, "cust-name")
    e.clear()
    e.send_keys(data.get("cust_name", ""))

    e = driver.find_element(By.NAME, "cust-name-kana")
    e.clear()
    e.send_keys(data.get("cust_name_kana", ""))

    e = driver.find_element(By.NAME, "mail-address")
    e.clear()
    e.send_keys(data.get("mail_address", ""))

    e = driver.find_element(By.NAME, "phone-number")
    e.clear()
    e.send_keys(data.get("phone_number", ""))

    Select(driver.find_element(By.NAME, "sex")).select_by_visible_text(data.get("sex", ""))

    e = driver.find_element(By.NAME, "born-date")
    e.clear()
    e.send_keys(data.get("born_date", ""))

    company_id = str(data.get("company_id", ""))
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, f"//select[@name='company-id']/option[@value='{company_id}']"))
    )
    Select(driver.find_element(By.NAME, "company-id")).select_by_value(company_id)


def login(driver):
    driver.get("http://localhost:3000/user_login")
    driver.find_element(By.NAME, "user-name").send_keys("nakabayashi")
    driver.find_element(By.NAME, "password").send_keys("nakabayashi2025")
    driver.find_element(By.XPATH, "//button[text()='ログイン']").click()
    WebDriverWait(driver, 5).until(EC.alert_is_present())
    driver.switch_to.alert.accept()

if __name__ == "__main__":
    test_data_list = [
        {"cust_name": "ばばばばばばばばばばややややややややややしししししししししし", "cust_name_kana": "ばばばばばばばばばばややややややややややしししししししししし", "mail_address": "Aaaa", "phone_number": "000へ0000-0000", "sex": "男性", "born_date": "002020/05/30", "company_id": "23"},
    ]

    for i, data in enumerate(test_data_list):
        print(f"\n▶ テストケース {i+1} 開始")
        test_edit(data)
