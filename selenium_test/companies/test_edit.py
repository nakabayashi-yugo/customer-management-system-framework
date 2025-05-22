from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from selenium.webdriver.common.keys import Keys
import time

chrome_driver_path = r"C:\Users\nakabayashi-yugo\tools\chromedriver-win64\chromedriver.exe"

def test_edit(data):
    service = Service(executable_path=chrome_driver_path)
    driver = webdriver.Chrome(service=service)
    login(driver)

    try:
        driver.get("http://localhost:3000/cust_entry")

        # 会社一覧ボタン押す(モーダル画面を出す)
        driver.find_element(By.XPATH, "//button[text()='会社一覧']").click()

        # モーダル画面が出るまで待つ
        WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.XPATH, "//button[text()='会社登録']"))
        )

        # 会社編集モーダル画面表示
        # 編集ボタンが出るまで最大10秒待つ
        edit_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "(//table[contains(@class,'modal-list-companies-table')]//button[text()='編集'])[1]"))
        )
        edit_button.click()

        # 会社編集モーダル画面が出るまで待つ
        WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.NAME, "company-name"))
        )

        # 入力する
        WebDriverWait(driver, 10).until(
            lambda d: d.find_element(By.NAME, "company-name").get_attribute("value").strip() != ""
        )
        fill_company_form(driver, data)

        time.sleep(1)

        # 「編集」ボタン押す
        modal = driver.find_element(By.CLASS_NAME, "modal-company-edit")
        modal.find_element(By.XPATH, ".//button[text()='編集']").click()

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
        assert "所属会社編集" in driver.page_source

    finally:
        driver.quit()

def fill_company_form(driver, data):
    e = driver.find_element(By.NAME, "company-name")
    e.send_keys(Keys.CONTROL, 'a')  # 全選択
    e.send_keys(Keys.DELETE)        # 全削除

    value = data.get("company_name", "")
    if value:
        e.send_keys(value)

def login(driver):
    driver.get("http://localhost:3000/user_login")
    driver.find_element(By.NAME, "user-name").send_keys("nakabayashi")
    driver.find_element(By.NAME, "password").send_keys("nakabayashi2025")
    driver.find_element(By.XPATH, "//button[text()='ログイン']").click()
    WebDriverWait(driver, 5).until(EC.alert_is_present())
    driver.switch_to.alert.accept()

if __name__ == "__main__":
    test_data_list = [
        {"company_name": ""},
        {"company_name": "株式会社ワニワニパニック科所属胴体部分専門製造製品取扱説明書発行現場専用弁当配達部門"},
        {"company_name": "株式会社ワニワニパニック"},
        {"company_name": "株式会社あおぞらマーケティング"},
    ]

    for i, data in enumerate(test_data_list):
        print(f"\n▶ テストケース {i+1} 開始")
        test_edit(data)
